<?php

namespace App\Livewire\App\Clients;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class ProductSettings extends Component
{
    use LivewireAlert, WithPagination;
    public $search = '';
    public $product_category_modal = false, $product_category_delete_modal = false;
    public $product_category,
        $title,
        $status,
        $is_edit;
    public $password = '';
    public function confirm_delete_product_category()
    {
        $this->validate([
            'password' => 'required|string|min:6',
        ]);

        // Check if the entered password is correct
        if (Hash::check($this->password, auth()->user()->password)) {
            ProductCategory::find($this->product_category->id)->update(['status' => 'discontinued']);
            $this->alert('success', 'Product Category deleted successfully!');
        } else {
            $this->alert('error', 'Incorrect password. Please try again.');
            return;
        }

        $this->product_category_delete_modal = false;
        $this->password = '';
    }
    public function delete_product_category($id)
    {
        $this->product_category_delete_modal = true;
        $this->product_category = ProductCategory::find(read($id));
    }

    public function add_product_category_modal()
    {
        $this->product_category_modal = true;
        $this->is_edit = false;
    }
    public function edit_product_category_modal($id)
    {
        $this->product_category_modal = true;
        $this->is_edit = true;
        $this->product_category = ProductCategory::find(read($id));
        $this->title = $this->product_category->title;
        $this->status = $this->product_category->status;
    }
    public function update_product_category()
    {
        $this->product_category->title = $this->title;
        $this->product_category->status = $this->status;
        $this->product_category->save();
        $this->alert('success', 'Product Category updated Successfully');
        $this->product_category_modal = false;
        $this->is_edit = false;
    }
    public function create_product_category()
    {
        if (ProductCategory::Where('title', $this->title)->first()) {
            $this->alert('info', 'Product Category already Exist');
            return;
        }
        $this->product_category = new ProductCategory();
        $this->product_category->title = $this->title;
        $this->product_category->status = $this->status;
        $this->product_category->save();
        $this->alert('success', 'Product Category created Successfully');
        $this->product_category_modal = false;
        $this->is_edit = false;
    }
    public function render()
    {
        $products = Product::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('brand', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(5);
        $categories = ProductCategory::where('title', 'like', '%' . $this->search . '%')
            ->orderBy('title')
            ->paginate(5);
        return view('livewire.app.clients.product-settings', compact('products', 'categories'));
    }
}
