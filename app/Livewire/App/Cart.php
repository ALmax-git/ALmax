<?php

namespace App\Livewire\App;

use App\Models\Cart as ModelsCart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Cart extends Component
{
    use WithPagination, LivewireAlert;

    public $cartItemIds = []; // Public property to store only the cart item IDs
    public $view_product_modal, $product_id, $variant_id, $Product;
    public $cart_delete_modal = false, $password, $cart;
    public $total = [
        'items' => 0,
        'price' => 0,
        'discount' => 0,
        'shipping' => 0,
    ];

    public function summary()
    {
        $this->total['items'] = 0;
        $this->total['price'] = 0;
        $this->total['discount'] = 0;
        $this->total['shipping'] = 0;

        foreach ($this->cartItems as $item) {
            if (!$item->is_selected) continue;
            $this->total['items'] += $item->quantity;
            $price = $item->variant_id ? $item->product->variants->find($item->variant_id)->sale_price : $item->product->sale_price;
            $this->total['price'] += $price * $item->quantity;
            $this->total['discount'] += ($item->product->discount / 100) * ($price * $item->quantity);
            // $this->total['shipping'] += $item->shipping_cost;
        }
    }
    public function mount()
    {
        $this->loadCartItemIds();
    }

    public function loadCartItemIds()
    {
        $this->cartItemIds = Auth::user()->cart_items()->latest()->pluck('id')->toArray();
        $this->summary(); // Call the summary method to update totals
    }

    public function getCartItemsProperty() // Computed property to fetch cart items with product relation
    {
        return ModelsCart::with('product')
            ->whereIn('id', $this->cartItemIds)
            ->latest()
            ->paginate(10);
    }

    public function toggleSelectItem(int $cartItemId)
    {
        $cart = ModelsCart::find($cartItemId);
        if ($cart) {
            $cart->update(['is_selected' => !$cart->is_selected]);
            $this->loadCartItemIds(); // Refresh the IDs to trigger re-render
        }
        $this->summary(); // Call the summary method to update totals
    }

    public function decrement($id)
    {
        $cart = ModelsCart::find($id);

        if ($cart) {
            if ($cart->quantity > 1) {
                --$cart->quantity;
            }
            $cart->save();
            $this->update_price($id);
        }
        $this->summary(); // Call the summary method to update totals
    }

    public function increment($id)
    {
        $cart = ModelsCart::find($id);
        if ($cart) {
            ++$cart->quantity; #= $cart->quatity + 1;
            $cart->save();
            $this->update_price($id);
        }
        $this->summary(); // Call the summary method to update totals
    }
    public function update_price($id): void
    {
        $variant_id = $this->variant_id ?? null;
        $cart = ModelsCart::find($id);
        $variant = $cart->product->variants->find($variant_id);
        $price = ($variant_id == 0 || $variant_id == null || !$variant) ? $cart->product->sale_price : $variant->sale_price;

        // Apply discount if applicable
        if ($cart->discount_percentage > 0) {
            $price = $price * (1 - ($cart->discount_percentage / 100));
        }

        // $cart->price = $price;
        // $cart->total = $price * $cart->quantity;
        $cart->installment_balance = $cart->total - $cart->paid_amount;
        $cart->save();
        $this->loadCartItemIds(); // Refresh the IDs to trigger re-render
        $this->summary(); // Call the summary method to update totals
    }

    public function open_view_product_modal($product_id, $variant_id = null)
    {
        $this->product_id = $product_id;
        $this->variant_id = $variant_id;
        $this->Product = Product::find($product_id);
        $this->view_product_modal = true;
    }
    public function close_view_product_modal()
    {
        $this->product_id = null;
        $this->variant_id = null;
        $this->view_product_modal = false;
    }


    public function delete_cart_modal($id)
    {
        $this->cart_delete_modal = true;
        $this->cart = ModelsCart::find(read($id));
    }
    public function confirm_delete_cart()
    {
        // $this->validate([
        //     'password' => 'required|string|min:6',
        // ]);

        // Check if the entered password is correct
        // if (Hash::check($this->password, auth()->user()->password)) {
        ModelsCart::destroy($this->cart->id);
        $this->alert('success', 'Cart Item deleted successfully!');
        // } else {
        //     $this->alert('error', 'Incorrect password. Please try again.');
        //     return;
        // }

        $this->cart_delete_modal = false;
        $this->cart = null;
        // $this->password = '';
    }
    public function close_delete_cart_modal()
    {
        $this->cart_delete_modal = false;
    }
    public function render()
    {
        return view('livewire.app.cart', [
            'cartItems' => $this->cartItems, // Access the computed property
        ]);
    }
}
