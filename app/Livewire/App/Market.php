<?php

namespace App\Livewire\App;

use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Component;

class Market extends Component
{
    public $search = '';
    public $category_id = null;
    public $varified_only = false;
    public $sort = 'latest'; // latest, oldest, low, high
    public $view_product_modal = false;
    public $Product = null;

    public function  open_view_product_modal($id): void
    {
        $this->Product = Product::find(read($id));
        $this->view_product_modal = true;
    }

    public function close_view_product_modal(): void
    {
        $this->Product = null;
        $this->view_product_modal = false;
    }
    public function render()
    {
        $products = Product::query()
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('brand', 'like', "%{$this->search}%")
                    ->orWhere('sub_title', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->when($this->category_id, fn($query) => $query->where('category_id', $this->category_id))
            ->when($this->varified_only, fn($query) => $query->whereHas('client', fn($q) => $q->where('is_verified', true)))
            ->when($this->sort === 'latest', fn($query) => $query->latest())
            ->when($this->sort === 'oldest', fn($query) => $query->oldest())
            ->when($this->sort === 'low', fn($query) => $query->orderBy('sale_price', 'asc'))
            ->when($this->sort === 'high', fn($query) => $query->orderBy('sale_price', 'desc'))
            ->paginate(10);

        $categories = ProductCategory::where('status', 'active')
            ->orderBy('title')
            ->get();
        $categories = $categories->map(function ($category) {
            $category->name = _app($category->name);
            return $category;
        });

        return view('livewire.app.market', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
