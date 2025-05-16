<?php

namespace App\Livewire\App\Client;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Sales extends Component
{
    use WithPagination, LivewireAlert;

    public $showModal = false;
    public $search = '';
    public $selectedProducts = [];
    public $quantities = [];
    public $discount = 0;
    public $detail_modal = false;
    public $sale;
    public $sale_list_view = false;
    public function mount($sale_list_view = false)
    {
        $this->sale_list_view = $sale_list_view;
    }
    public function add_new_sale_modal()
    {
        $this->reset(['selectedProducts', 'quantities', 'discount']);
        $this->showModal = true;
    }

    public function toggleProduct($productId)
    {
        if (in_array($productId, $this->selectedProducts)) {
            $index = array_search($productId, $this->selectedProducts);
            unset($this->selectedProducts[$index]);
            unset($this->quantities[$productId]);
        } else {
            $this->selectedProducts[] = $productId;
            $this->quantities[$productId] = 1;
        }
    }

    public function updatedQuantities()
    {
        // Triggers reactivity
    }

    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->selectedProducts as $productId) {
            $product = Product::find($productId);
            $quantity = $this->quantities[$productId] ?? 1;
            $price = $product->sale_price;
            $total += $quantity * $price;
        }

        return $total - (float) $this->discount;
    }
    public function store()
    {
        DB::beginTransaction();
        $clientId = Auth::user()->client->id;
        foreach ($this->selectedProducts as $productId) {
            $product = Product::find($productId);
            $quantity = $this->quantities[$productId] ?? 1;
            $price = $product->sale_price;
            $total = $quantity * $price;
            if ($product->available_stock < $quantity) {

                DB::rollBack();
                $this->alert('info', $product->name . ' is out of stock', ['position' => 'center']);
                return;
            }
            $product->sold += $quantity;
            $product->available_stock -= $quantity;
            $product->save();
            Sale::create([
                'client_id' => $clientId,
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $total,
                'discount' => $this->discount > 0 ? $this->discount : 0,
            ]);
        }
        DB::commit();

        $this->showModal = false;
    }

    public function view_sale($id)
    {
        $this->sale = Sale::find(read($id));
        if (!$this->sale) {
            $this->alert('error', 'Sale not found');
            return;
        }
        $this->detail_modal = true;
    }
    public function close_detail_modal()
    {
        $this->sale = null;
        $this->detail_modal = false;
    }
    public function render()
    {
        $sales = user_can_access('manage_sales') ?
            Auth::user()->client->sales()
            ->with(['user', 'client', 'product'])
            ->latest()
            ->paginate(5)
            :
            Auth::user()->sales()
            ->with(['user', 'client', 'product'])
            ->latest()
            ->paginate(5);

        $products = Product::where('name', 'like', '%' . $this->search . '%')
            ->limit(15)
            ->orderBy('name')
            ->get();
        $totalSales = Sale::where('client_id', Auth::user()->client->id)
            ->sum('total');
        $totalDiscount = Sale::where('client_id', Auth::user()->client->id)
            ->sum('discount');
        return view('livewire.app.client.sales', [
            'sales' => $sales,
            'products' => $products,
            'totalSales' => $totalSales,
            'totalDiscount' => $totalDiscount,
        ]);
    }
}
