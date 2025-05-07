<?php

namespace App\Livewire\Component\Card;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Productview extends Component
{
    use LivewireAlert;
    public $product, $variant_id, $variant, $id;
    public $image_path;
    public function mount($id, $variant_id = null): void
    {
        $this->id = $id;
        $this->product = Product::find($id);
        $this->image_path = $this->product->images()->first();
        $this->image_path = $this->image_path ? $this->image_path->path : null;
        if ($variant_id) {
            $this->variant_id = $variant_id;
            $this->variant = ProductVariant::find($variant_id);
        }
    }

    public function show_image($path)
    {
        $this->image_path = $path;
    }
    public function select_variant($variant_id)
    {
        $this->variant_id = read($variant_id);
        $this->variant = ProductVariant::find(read($variant_id));
    }

    // public function add_to_cart($product_id, $variant_id = null): void
    // {

    //     $this->product = Product::find(read($product_id));
    //     $cart = $variant_id != 0 && $variant_id != null ?
    //         Auth::user()->cart_items()->where('product_id', read($product_id))->where('variant_id', read($variant_id))->first() :
    //         Auth::user()->cart_items()->where('product_id', read($product_id))->where('variant_id', null)->first();
    //     if ($cart) {
    //         $cart->increment('quantity');
    //         $cart->price = ($variant_id == 0 || $variant_id == null) ? $this->product->variants->find(read($variant_id))->sale_price : $this->product->sale_price;
    //         $cart->total = (($variant_id == 0 || $variant_id == null) ? $this->product->variants->find(read($variant_id))->sale_price : $this->product->sale_price) * $cart->quantity;
    //         $cart->installment_balance = $cart->total - $cart->paid_amount;
    //         $cart->save();
    //     } else {
    //         Auth::user()->cart_items()->create([
    //             'product_id' => read($product_id),
    //             'variant_id' => ($variant_id == 0 || $variant_id == null) ? read($variant_id) : null,
    //             'quantity' => 1,
    //             'user_id' => Auth::id(),
    //             'price' => ($variant_id == 0 || $variant_id == null) ? $this->product->variants->find(read($variant_id))->sale_price : $this->product->sale_price,
    //             'total' => ($variant_id == 0 || $variant_id == null) ? $this->product->variants->find(read($variant_id))->sale_price : $this->product->sale_price,
    //             'installment_balance' => ($variant_id == 0 || $variant_id == null) ? $this->product->variants->find(read($variant_id))->sale_price : $this->product->sale_price,
    //         ]);
    //     }
    //     $this->alert('success', 'Product added to cart successfully!', [
    //         'position' => 'top-end',
    //         'timer' => 3000,
    //         'toast' => true,
    //     ]);
    // }
    public function add_to_cart($product_id, $variant_id = null): void
    {
        $user = Auth::user();
        $quantity = 1;
        $product_id = read($product_id);
        $variant_id = read($variant_id);
        // Fetch product (with price validation)
        $product = Product::findOrFail($product_id);
        $base_price = $product->sale_price;
        $discount_percent = $product->discount;
        // dd($user, $product, $base_price, $discount_percent);
        // Apply discount if provided
        $final_price = $base_price;
        if ($discount_percent > 0 && $discount_percent <= 100) {
            $final_price = round($base_price - ($base_price * $discount_percent / 100), 2);
        }

        // Check if similar cart item already exists
        $existingCartItem = Cart::where([
            'user_id'    => $user->id,
            'product_id' => $product_id,
            'variant_id' => $variant_id,
            'status'     => 'pending',
        ])->first();

        if ($existingCartItem) {
            // Update quantity and total
            ++$existingCartItem->quantity;
            // $existingCartItem->price = $final_price;
            // $existingCartItem->total = $existingCartItem->quantity * $final_price;
            $existingCartItem->installment_balance = $existingCartItem->quantity * $final_price - $existingCartItem->paid_amount;
            $existingCartItem->save();
            $this->alert('info', 'Product added to cart successfully!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        } else {
            // Create new cart entry
            Cart::create([
                'user_id'            => $user->id,
                'product_id'         => $product_id,
                'variant_id'         => $variant_id,
                'quantity'           => $quantity,
                // 'price'              => $final_price,
                // 'total'              => $quantity * $final_price,
                'status'             => 'pending',
                'paid_amount'        => 0,
                'installment_balance' => $quantity * $final_price,
                'is_selected'        => true,
            ]);
            $this->alert('success', 'Product added to cart successfully!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }


    public function render()
    {
        return view('livewire.component.card.productview');
    }
}
