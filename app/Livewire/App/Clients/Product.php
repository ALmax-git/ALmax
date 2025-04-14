<?php

namespace App\Livewire\App\Clients;

use App\Models\File;
use App\Models\Product as ModelsProduct;
use App\Models\ProductCategory;
use BaconQrCode\Common\Mode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
    public $is_edit = false;
    public $product_delete_modal = false;
    public $password = '';
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
        $this->reset_input_fields();
        $this->product_modal = true;
    }
    public function edit_product_modal($id)
    {
        $this->reset_input_fields();
        $this->product_modal = true;
        $this->is_edit = true;
        $this->product = ModelsProduct::find(read($id));
        $this->name = $this->product->name;
        $this->brand = $this->product->brand;
        $this->sub_title = $this->product->sub_title;
        $this->category_id = $this->product->category_id;
        $this->description = $this->product->description;
        $this->discount = $this->product->discount;
        $this->stock_price = $this->product->stock_price;
        $this->sale_price = $this->product->sale_price;
        $this->available_stock = $this->product->available_stock;
        $this->color = $this->product->color;
        $this->size = $this->product->size;
        $this->si_unit = $this->product->si_unit;
        $this->weight = $this->product->weight;
        $this->status = $this->product->status;
        $this->sold = $this->product->sold;
        $this->image = $this->product->image;
    }
    public function update_product()
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
            // 'image.*'           => 'nullable|image|max:6024', // max size 1MB
            'size'              => 'required|numeric', // max size 10MB
            'si_unit'           => 'nullable|string',
            'weight'            => 'required|numeric|min:0',
        ]);
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
            $this->product = ModelsProduct::find($this->product->id);
            $this->product->update([
                // Update only the fields that are changed
                // You can add more fields as needed
                // If you want to update all fields, you can use $validatedData directly
                // but make sure to remove the image field from the validation rules above
                // or handle it separately.
                // Example:
                // $this->product->update($validatedData);
                // Or:
                // $this->product->update($this->product);
                // But here we are updating only the necessary fields for simplicity.
                // You can also use fill() method if you want to update multiple fields at once.
                // $this->product->fill($validatedData)->save();
                // Or:
                // $this->product->fill($this->product)->save();
                // But here we are updating
                // only the necessary fields for simplicity.
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
                'status' => $this->status,
                'sold' => $this->sold,
            ]);
            // Save product images
            if ($this->image) {
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
            }
            DB::commit();  // Commit transaction if everything is successful
            $this->alert('success', 'Product successfully updated', ['position' => 'center']);
            $this->product_modal = false;
        } catch (\Exception $e) {
            Log::error('An unexpected error occurred: ' . $e);
            DB::rollback();  // Rollback transaction on failure
            $this->alert('error', 'Failed to update product' . $e->getMessage(), ['position' => 'center']);
        }
    }
    public function delete_product_modal($id)
    {
        $this->product_delete_modal = true;
        $this->product = ModelsProduct::find(read($id));
    }
    public function confirm_delete_product()
    {
        $this->validate([
            'password' => 'required|string|min:6',
        ]);

        // Check if the entered password is correct
        if (Hash::check($this->password, auth()->user()->password)) {
            Product::destroy($this->product_category->id);
            $this->alert('success', 'Product Category deleted successfully!');
        } else {
            $this->alert('error', 'Incorrect password. Please try again.');
            return;
        }

        $this->product_delete_modal = false;
        $this->password = '';
    }
    public function reset_input_fields()
    {
        $this->name = '';
        $this->brand = '';
        $this->sub_title = '';
        $this->category_id = '';
        $this->description = '';
        $this->discount = '';
        $this->stock_price = '';
        $this->sale_price = '';
        $this->available_stock = '';
        $this->color = '';
        $this->size = '';
        $this->si_unit = '';
        $this->weight = '';
        $this->status = '';
        $this->sold = '';
        $this->image = '';
        $this->product = '';
        $this->product_modal = false;
        $this->is_edit = false;
        $this->product_delete_modal = false;
        $this->password = '';
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
