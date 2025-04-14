<?php

namespace App\Livewire\App\Clients;

use App\Models\File;
use App\Models\Product as ModelsProduct;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Product extends Component
{
    use WithFileUploads, LivewireAlert;
    public $search = '';
    public $product_modal = false;
    public $product,
        $name,
        $brand,
        $sub_title,
        $category_id,
        $description,
        $discount,
        $stock_price,
        $sale_price,
        $available_stock,
        $color,
        $size,
        $si_unit,
        $weight,
        $status,
        $sold,
        $image;
    public function create_product()
    {
        $validatedData = $this->validate([
            'name'              => 'required|string|max:100',
            'brand'             => 'required|string|max:100',
            'sub_title'         => 'required|string|max:255',
            'category_id'       => 'required|integer|exists:product_categories,id',
            'description'       => 'required|string',
            'discount'          => 'required|numeric',
            'stock_price'       => 'required|numeric',
            'sale_price'        => 'required|numeric',
            'available_stock'   => 'required|numeric',
            'color'             => 'required',
            'image.*'           => 'required|image|max:6024', // max size 1MB
            'size'              => 'required|numeric', // max size 10MB
            'si_unit'           => 'nullable|string',
            'weight'            => 'required|numeric|min:0',
        ]);
        // Log::error('An unexpected error occurred: ');
        if (ModelsProduct::where('name', $this->name)->where('client_id', Auth::user()->client_id)->count() > 0) {
            $this->alert(
                'info',
                'Oops! You can not create Products Services with the same name.',
                [
                    'position' => 'center',
                    'toast' => 1,
                    'showConfirmButton' => true,
                    'timer' => null
                ]
            );
            return;
        }
        if ($this->sale_price <= $this->stock_price) {
            $this->alert(
                'info',
                'Oops! Sale price most be greater than the stock price.',
                [
                    'position' => 'center',
                    'toast' => 1,
                    'showConfirmButton' => true,
                    'timer' => null
                ]
            );
            return;
        }
        DB::beginTransaction();
        try {
            // Save new product
            $this->product = ModelsProduct::create([
                'client_id' => Auth::user()->client_id,
                'user_id' => Auth::user()->id,
                'name' => $this->name,
                'brand' => $this->brand,
                'sub_title' => $this->sub_title,
                'category_id' => $this->category_id,
                'description' => $this->description,
                'stock_price' => $this->stock_price,
                'sale_price' => $this->sale_price,
                'available_stock' => $this->available_stock,
                'color' => $this->color,
                'size' => $this->size,
                'discount' => $this->discount,
                'si_unit' => $this->si_unit,
                'weight' => $this->weight,
            ]);

            // Save product images
            foreach ($this->image as $file) {
                $file_name = $file->store('products', 'public');

                File::create([
                    'label' => $this->product->id,
                    'path' => $file_name,
                    'description' => 'Product Image: ' . $this->product->name,
                    'visibility' => 'public',
                    'info' => 'Product Image: ' . $this->product->name,
                    'mimes' => Storage::mimeType($file_name),
                    'type' => 'product_image',
                    'user_id' => Auth::user()->id,
                    'client_id' => Auth::user()->client_id,
                ]);
            }


            DB::commit();  // Commit transaction if everything is successful

            $this->alert('success', 'Product successfully added', ['position' => 'center']);

            $this->product_modal = false;
        } catch (\Exception $e) {
            Log::error('An unexpected error occurred: ' . $e);
            DB::rollback();  // Rollback transaction on failure
            $this->alert('error', 'Failed to add product' . $e->getMessage(), ['position' => 'center']);
        }
    }
    public function add_product_modal()
    {
        $this->product_modal = true;
    }
    public function render()
    {

        $products = ModelsProduct::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('brand', 'like', '%' . $this->search . '%')
            ->orWhere('sub_title', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(5);
        $categories = ProductCategory::orderBy('title')->get();
        return view('livewire.app.clients.product', compact('products', 'categories'));
    }
}
