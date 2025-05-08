<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supply;

class SupplyController extends Controller
{
    public function index()
    {
        $supplies = Supply::all();
        return view('supplies.index', compact('supplies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'category' => 'required|integer|exists:product_categories,id',
            'cost_price_per_each' => 'required|numeric',
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        Supply::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'category_id' => $request->category,
            'cost_price_per_each' => $request->cost_price_per_each,
            'image' => $imagePath,
        ]);

        return redirect()->route('supply.index')->with('success', 'Supply created successfully.');
    }

    public function show($id)
    {
        $supply = Supply::findOrFail($id);
        return view('supplies.show', compact('supply'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'category' => 'required|integer|exists:product_categories,id',
            'cost_price_per_each' => 'required|numeric',
            'image' => 'sometimes|image|max:2048',
        ]);

        $supply = Supply::findOrFail($id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $supply->update([
                'name' => $request->name,
                'brand' => $request->brand,
                'type' => $request->type,
                'quantity' => $request->quantity,
                'category_id' => $request->category,
                'cost_price_per_each' => $request->cost_price_per_each,
                'image' => $imagePath,
            ]);
        } else {
            $supply->update($request->only(['name', 'brand', 'type', 'quantity', 'category', 'cost_price_per_each']));
        }

        return redirect()->route('supply.index')->with('success', 'Supply updated successfully.');
    }

    public function destroy($id)
    {
        $supply = Supply::findOrFail($id);
        $supply->delete();
        return redirect()->route('supply.index')->with('success', 'Supply deleted successfully.');
    }
}