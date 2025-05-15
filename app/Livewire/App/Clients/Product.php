<?php

namespace App\Livewire\App\Clients;

use App\Models\Addon;
use App\Models\File;
use App\Models\Label;
use App\Models\Product as ModelsProduct;
use App\Models\ProductCategory;
use App\Models\ProductVariant;
use BaconQrCode\Common\Mode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
    public $product_view_modal = false;
    public $product_image_modal = false;
    public $product_image_delete_modal = false;
    public $product_variant_modal = false;
    public $product_variant_delete_modal = false;
    public $product_addons_modal = false;
    public $product_addons_delete_modal = false;
    public $label_model = false;
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
        $image,
        $addon_product_id,
        $base_product_id,
        $required,
        $addon,
        $label;

    public $product_variant;
    // public $
    public $qrCodes = [];

    public function view_product_modal($id)
    {
        $this->product = ModelsProduct::find(read($id));
        $this->product_view_modal = true;
    }
    public function delete_product_image_modal($id)
    {
        $this->product_image_delete_modal = true;
        $this->product_view_modal = false;
        $this->image = File::find(read($id));
    }
    public function close_delete_product_image_modal()
    {
        $this->product_image_delete_modal = false;
        $this->product_view_modal = true;
    }
    public function open_product_images_modal()
    {
        $this->image = null;
        $this->product_image_modal = true;
        $this->product_view_modal = false;
    }
    public function close_product_images_modal()
    {
        $this->product_image_modal = false;
        $this->product_view_modal = true;
    }
    public function create_product()
    {

        $validatedData = $this->validate([
            'name'              => 'required|string|max:100',
            'brand'             => 'required|string|max:100',
            'sub_title'         => 'required|string|max:255',
            'category_id'       => 'required|integer|exists:product_categories,id',
            'description'       => 'nullable|string',
            'discount'          => 'nullable|numeric',
            'stock_price'       => 'nullable|numeric',
            'sale_price'        => 'required|numeric',
            'available_stock'   => 'required|numeric',
            'color'             => 'nullable',
            'image.*'           => 'nullable|image|max:6024', // max size 1MB
            'size'              => 'nullable|string', // max size 10MB
            'si_unit'           => 'nullable|string',
            'weight'            => 'nullable|numeric|min:0',
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
        if ($this->stock_price) {
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
                'description' => $this->description ?? 'Not Available',
                'stock_price' => $this->stock_price > 0 ? $this->stock_price : $this->sale_price,
                'sale_price' => $this->sale_price,
                'available_stock' => $this->available_stock,
                'color' => $this->color ?? '#fff',
                'size' => $this->size ?? '',
                'discount' => $this->discount > 0 ? $this->discount : 0  ?? 0,
                'si_unit' => $this->si_unit ?? 'g',
                'weight' => $this->weight ?? 0,
            ]);

            // Save product images
            if ($this->image > 0) {
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
            'description'       => 'nullable|string',
            'discount'          => 'nullable|numeric',
            'stock_price'       => 'nullable|numeric',
            'sale_price'        => 'required|numeric',
            'available_stock'   => 'required|numeric',
            'color'             => 'nullable',
            'image.*'           => 'nullable|image|max:6024', // max size 1MB
            'size'              => 'nullable|string', // max size 10MB
            'si_unit'           => 'nullable|string',
            'weight'            => 'nullable|numeric|min:0',
        ]);
        if ($this->stock_price > 0) {
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
                'description' => $this->description ?? 'Not Available',
                'stock_price' => $this->stock_price > 0 ? $this->stock_price : $this->sale_price,
                'sale_price' => $this->sale_price,
                'available_stock' => $this->available_stock,
                'color' => $this->color ?? '#fff',
                'size' => $this->size ?? '',
                'discount' => $this->discount > 0 ? $this->discount : 0,
                'si_unit' => $this->si_unit ?? 'g',
                'weight' => $this->weight ?? 0,
                'status' => $this->status,
                // 'sold' => $this->sold,
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
    public function upload_product_image()
    {
        $this->validate([
            'image.*' => 'required|image|max:6024', // max size 1MB
        ]);
        DB::beginTransaction();
        try {
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
            $this->alert('success', 'Product image successfully uploaded', ['position' => 'center']);
            $this->product_image_modal = false;
        } catch (\Exception $e) {
            Log::error('An unexpected error occurred: ' . $e);
            DB::rollback();  // Rollback transaction on failure
            $this->alert('error', 'Failed to upload product image' . $e->getMessage(), ['position' => 'center']);
        }
        $this->product = ModelsProduct::find($this->product->id);
        $this->product_view_modal = true;
        $this->product_image_modal = false;
        $this->product_image_delete_modal = false;
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
    public function confirm_delete_product_image()
    {
        $this->validate([
            'password' => 'required|string|min:6',
        ]);

        // Check if the entered password is correct
        if (Hash::check($this->password, auth()->user()->password)) {
            $this->image->delete();
            $this->alert('success', 'Product Image deleted successfully!');
        } else {
            $this->alert('error', 'Incorrect password. Please try again.');
            return;
        }

        $this->product_image_delete_modal = false;
        $this->product = ModelsProduct::find($this->product->id);
        $this->product_view_modal = true;
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
        // $this->product = '';
        $this->product_modal = false;
        $this->is_edit = false;
        $this->product_delete_modal = false;
        $this->password = '';
        $this->label = '';
    }
    public function open_add_variant_modal()
    {
        $this->product_variant_modal = true;
        $this->product_view_modal = false;
        $this->reset_input_fields();
        $this->product_variant = null;
    }
    public function close_add_variant_modal()
    {
        $this->product_variant_modal = false;
        $this->product_view_modal = true;
    }
    public function create_product_variant()
    {
        $validatedData = $this->validate([
            'size'              => 'required|string',
            'color'             => 'required|string|max:100',
            'si_unit'           => 'nullable|string',
            'weight'            => 'required|numeric|min:0',
            'stock_price'       => 'required|numeric',
            'sale_price'        => 'required|numeric',
            'available_stock'   => 'required|numeric',
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
            // Save new product variant
            $this->product = ModelsProduct::find($this->product->id);
            $this->product->variants()->create([
                'label' => $this->label,
                'size' => $this->size,
                'color' => $this->color,
                'si_unit' => $this->si_unit,
                'weight' => $this->weight,
                'stock_price' => $this->stock_price,
                'sale_price' => $this->sale_price,
                'available_stock' => $this->available_stock,
                'client_id' => Auth::user()->client_id,
                'user_id' => Auth::user()->id,
            ]);

            DB::commit(); // Commit transaction if everything is successful
            $this->alert('success', 'Product variant successfully added', ['position' => 'center']);
            $this->product_variant_modal = false;
        } catch (\Exception $e) {
            Log::error('An unexpected error occurred: ' . $e);
            DB::rollback(); // Rollback transaction on failure
            $this->alert('error', 'Failed to add product variant: ' . $e->getMessage(), ['position' => 'center']);
        }
    }
    public function edit_variant_modal($id)
    {
        $this->product_variant = ProductVariant::find(read($id));
        $this->product_variant_modal = true;
        $this->product_view_modal = false;
        $this->label = $this->product_variant->label;
        $this->size = $this->product_variant->size;
        $this->color = $this->product_variant->color;
        $this->si_unit = $this->product_variant->si_unit;
        $this->weight = $this->product_variant->weight;
        $this->stock_price = $this->product_variant->stock_price;
        $this->sale_price = $this->product_variant->sale_price;
        $this->available_stock = $this->product_variant->available_stock;
        $this->status = $this->product_variant->status;
        // $this->sold = $this->product_variant->sold;
        $this->is_edit = true;
    }
    public function update_product_variant()
    {
        $validatedData = $this->validate([
            'size'              => 'required|string',
            'color'             => 'required|string|max:100',
            'si_unit'           => 'nullable|string',
            'weight'            => 'required|numeric|min:0',
            'stock_price'       => 'required|numeric',
            'sale_price'        => 'required|numeric',
            'available_stock'   => 'required|numeric',
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
            // Save new product variant
            $this->product_variant = ProductVariant::find($this->product_variant->id);
            $this->product_variant->update([
                // Update only the fields that are changed
                // You can add more fields as needed
                // If you want to update all fields, you can use $validatedData directly
                // but make sure to remove the image field from the validation rules above
                // or handle it separately.
                // Example:
                // $this->product_variant->update($validatedData);
                // Or:
                // $this->product_variant->update($this->product_variant);
                // But here we are updating only the necessary fields for simplicity.
                // You can also use fill() method if you want to update multiple fields at once.
                // $this->product_variant->fill($validatedData)->save();
                // Or:
                // $this->product_variant->fill($this->product_variant)->save();
                // But here we are updating
                // only the necessary fields for simplicity.
                // $this->product_variant = ModelsProduct::find($this->product_variant->id);
                'label' => $this->label,
                'size' => $this->size,
                'color' => $this->color,
                'si_unit' => $this->si_unit,
                'weight' => $this->weight,
                'stock_price' => $this->stock_price,
                'sale_price' => $this->sale_price,
                'available_stock' => $this->available_stock,
                'status' => $this->status,
                'sold' => $this->sold,
            ]);
            DB::commit(); // Commit transaction if everything is successful
            $this->alert('success', 'Product variant successfully updated', ['position' => 'center']);
            $this->product_variant_modal = false;
            $this->product_view_modal = true;
            $this->is_edit = false;
        } catch (\Exception $e) {
            Log::error('An unexpected error occurred: ' . $e);
            DB::rollback(); // Rollback transaction on failure
            $this->alert('error', 'Failed to update product variant: ' . $e->getMessage(), ['position' => 'center']);
        }
    }
    public function delete_product_variant_modal($id)
    {
        $this->product_variant_delete_modal = true;
        $this->product_view_modal = false;
        $this->product_variant = ProductVariant::find(read($id));
    }
    public function confirm_delete_product_variant()
    {
        $this->validate([
            'password' => 'required|string|min:6',
        ]);

        // Check if the entered password is correct
        if (Hash::check($this->password, auth()->user()->password)) {
            ProductVariant::destroy($this->product_variant->id);
            $this->alert('success', 'Product variant deleted successfully!');
        } else {
            $this->alert('error', 'Incorrect password. Please try again.');
            return;
        }

        $this->product_variant_delete_modal = false;
        $this->product_view_modal = true;
        $this->product_variant = null;
        $this->password = '';
    }
    public function close_delete_product_variant_modal()
    {
        $this->product_variant_delete_modal = false;
        $this->product_view_modal = true;
    }
    public function open_add_addons_modal()
    {
        $this->product_addons_modal = true;
        $this->product_view_modal = false;
        $this->reset_input_fields();
    }
    public function close_add_product_addons_modal()
    {
        $this->product_addons_modal = false;
        $this->product_view_modal = true;
    }
    public function create_product_addons()
    {
        $validatedData = $this->validate([
            'addon_product_id' => 'required|integer|exists:products,id',
            'label' => 'required|string|max:100',
            'required' => 'nullable|boolean',
        ]);
        DB::beginTransaction();
        if ($this->product->addons()->where('addon_product_id', $this->addon_product_id)->exists()) {
            $this->alert(
                'info',
                'Oops! This addon already exists for the product.',
                [
                    'position' => 'center',
                    'toast' => 1,
                    'showConfirmButton' => true,
                    'timer' => null
                ]
            );
            return;
        }
        if ($this->product->addons()->where('label', $this->label)->exists()) {
            $this->alert(
                'info',
                'Oops! An addon with the same label already exists for this product.',
                [
                    'position' => 'center',
                    'toast' => 1,
                    'showConfirmButton' => true,
                    'timer' => null
                ]
            );
            return;
        }
        try {
            // Save new product
            $this->product = ModelsProduct::find($this->product->id);
            $this->product->addons()->create([
                'addon_product_id' => $this->addon_product_id,
                'base_product_id' => $this->product->id,
                'category_id' => $this->product->category_id,
                'required' => $this->required,
                'label' => $this->label,
            ]);

            DB::commit();  // Commit transaction if everything is successful

            $this->alert('success', 'Product successfully added', ['position' => 'center']);

            $this->product_addons_modal = false;
            $this->product_view_modal = true;
        } catch (\Exception $e) {
            Log::error('An unexpected error occurred: ' . $e);
            DB::rollback();  // Rollback transaction on failure
            $this->alert('error', 'Failed to add product' . $e->getMessage(), ['position' => 'center']);
        }
    }
    public function delete_product_addons_modal($id)
    {
        $this->product_addons_delete_modal = true;
        $this->product_view_modal = false;
        $this->addon = Addon::find(read($id));
    }
    public function confirm_delete_product_addons()
    {
        $this->validate([
            'password' => 'required|string|min:6',
        ]);

        // Check if the entered password is correct
        if (Hash::check($this->password, auth()->user()->password)) {
            Addon::destroy($this->addon->id);
            $this->alert('success', 'Product addon deleted successfully!');
        } else {
            $this->alert('error', 'Incorrect password. Please try again.');
            return;
        }

        $this->product_addons_delete_modal = false;
        $this->product_view_modal = true;
        $this->product_variant = null;
        $this->password = '';
    }
    public function close_delete_product_addons_modal()
    {
        $this->product_addons_delete_modal = false;
        $this->product_view_modal = true;
    }
    public function edit_product_addons_modal($id)
    {
        $this->product_addons_modal = true;
        $this->product_view_modal = false;
        $this->addon = Addon::find(read($id));
        $this->addon_product_id = $this->addon->addon_product_id;
        $this->base_product_id = $this->addon->base_product_id;
        $this->label = $this->addon->label;
        $this->required = $this->addon->required;
        $this->is_edit = true;
    }
    public function update_product_addons()
    {
        $validatedData = $this->validate([
            'addon_product_id' => 'required|integer|exists:products,id',
            'label' => 'required|string|max:100',
            'required' => 'nullable|boolean',
        ]);
        // if ($this->product->addons()->where('addon_product_id', $this->addon_product_id)->exists() ) {
        //     $this->alert(
        //         'info',
        //         'Oops! This addon already exists for the product.',
        //         [
        //             'position' => 'center',
        //             'toast' => 1,
        //             'showConfirmButton' => true,
        //             'timer' => null
        //         ]
        //     );
        //     return;
        // }
        if ($this->product->addons()->where('label', $this->label)->exists() && $this->addon->label != $this->label) {
            $this->alert(
                'info',
                'Oops! An addon with the same label already exists for this product.',
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
            $this->addon = Addon::find($this->addon->id);
            $this->addon->update([
                'addon_product_id' => $this->addon_product_id,
                'base_product_id' => $this->product->id,
                'category_id' => $this->product->category_id,
                'required' => $this->required,
                'label' => $this->label,
            ]);

            DB::commit();  // Commit transaction if everything is successful

            $this->alert('success', 'Product successfully updated', ['position' => 'center']);

            $this->product_addons_modal = false;
            $this->product_view_modal = true;
        } catch (\Exception $e) {
            Log::error('An unexpected error occurred: ' . $e);
            DB::rollback();  // Rollback transaction on failure
            $this->alert('error', 'Failed to add product' . $e->getMessage(), ['position' => 'center']);
        }
    }
    public function sync_all()
    {
        // Get all products
        $products = ModelsProduct::with(['variants', 'labels'])->get();

        foreach ($products as $product) {
            // 1. Sync Product Labels
            $this->syncProductLabels($product);

            // 2. Sync Variant Labels
            foreach ($product->variants as $variant) {
                $this->syncVariantLabels($variant, $product);
            }
        }

        $this->alert('success', 'synchronized successfully!', ['position' => 'center']);
    }
    protected function syncProductLabels($product)
    {
        $expectedLabelsCount = $product->available_stock; // Or any logic to determine how many labels you expect

        // Check how many labels exist for this product without variant
        $existingLabels = Label::where('product_id', $product->id)
            ->whereNull('variant_id')
            ->get();

        $missing = $expectedLabelsCount - $existingLabels->count();

        // If missing, generate
        if ($missing > 0) {
            app('App\Services\LabelService')->bulkCreateLabels($product->id, null, $missing, $product->status);
        }

        if ($existingLabels->count() > $expectedLabelsCount) {
            $existingLabels = $existingLabels->slice($expectedLabelsCount);
            foreach ($existingLabels as $label) {
                $label->delete();
            }
        }

        // Sync status for all labels
        foreach ($existingLabels as $label) {

            $label->update([
                'status' => $product->status,
            ]);
        }
    }
    protected function syncVariantLabels($variant, $product)
    {
        $expectedLabelsCount = $variant->available_stock; // Or any logic to determine how many labels you expect

        $existingLabels = Label::where('product_id', $product->id)
            ->where('variant_id', $variant->id)
            ->get();

        $missing = $expectedLabelsCount - $existingLabels->count();

        if ($missing > 0) {
            app('App\Services\LabelService')->bulkCreateLabels($product->id, $variant->id, $missing, $product->status);
        }
        if ($existingLabels->count() > $expectedLabelsCount) {
            $existingLabels = $existingLabels->slice($expectedLabelsCount);
            foreach ($existingLabels as $label) {
                $label->delete();
            }
        }
        // Sync status for all labels
        foreach ($existingLabels as $label) {
            $label->update([
                'status' => $product->status,
            ]);
        }
    }

    public function open_label_model($product_id, $variant_id = null)
    {
        // $this->product_view_modal = false;
        $this->label_model = true;
        $this->product = ModelsProduct::find($product_id);
        foreach ($this->product->labels as $label) {
            $this->qrCodes[$label->id] = generate_qr_code($label->qr_key);
        }
        if ($variant_id) {
            $this->product_variant = ProductVariant::find($variant_id);
        } else {
            $this->product_variant = null;
        }
    }
    public function close_label_modal()
    {
        $this->label_model = false;
        // $this->product_view_modal = true;
        $this->product_variant = null;
    }

    public function render()
    {
        $products = ModelsProduct::query()
            ->where('client_id', Auth::user()->client_id)
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('brand', 'like', '%' . $this->search . '%')
                    ->orWhere('sub_title', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate(5);
        $categories = ProductCategory::where('status', 'active')->orderBy('title')->get();
        return view('livewire.app.clients.product', compact('products', 'categories'));
    }
}
