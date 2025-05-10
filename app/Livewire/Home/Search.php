<?php

namespace App\Livewire\Home;

use App\Models\Product;
// use App\Models\Service;
use App\Models\User;
use Livewire\Component;

class Search extends Component
{
    public $search = '', $people, $products, $services, $tab = 'all';
    public $search_model = false;
    public $selectedCategory = 'all';
    public function open_model()
    {
        $this->search_model = true;
    }
    public function close_model()
    {
        $this->search_model = false;
    }
    public function search_public()
    {
        $this->products = Product::where('status', '!=', 'trash')
            ->where('name', 'like', '%' . $this->search . '%')
            ->with(['category', 'images'])->get();
        // ->paginate(10);

        // $this->services = Service::where('name', 'like', '%' . $this->search . '%')
        //     ->where('status', '!=', 'trash')  // Exclude products with 'trash' status
        //     ->with(['category_name', 'images'])->get(); // Eager load category and images
        // // ->paginate(10);

        $this->people = User::where('visibility', 'public')
            ->where('name', 'like', '%' . $this->search . '%')
            // ->where('status', '!=', 'trash')
            ->get();  // Exclude products with 'trash' status
        // ->paginate(10);
        // dd($this);
    }
    public function render()
    {
        return view('livewire.home.search');
    }
}
