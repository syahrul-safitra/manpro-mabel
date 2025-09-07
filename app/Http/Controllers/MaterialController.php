<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Item;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OrderProduct $order)
    {
        return $order->load('material');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(OrderProduct $order)
    {

        $order->load('material');

        $getItemIdInMaterial = $order->material->pluck('item_id');

        return view('Admin.Material.create', [
            'items' => Item::whereNotIn('id', $getItemIdInMaterial)->get(),
            'order_id' => $order->id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric',
            'order_product_id' => 'required', 
            'item_id' => 'required' 
        ]);

        Material::create($validated);

        return redirect('detail-order/' . $validated['order_product_id'])->with('success', 'Berhasil menambahkan material');
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        return view('Admin.Material.edit', [
            'material' => $material->load('item')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric'
        ]);

        $material->update($validated);

        return redirect('detail-order/' . $material->order_product_id)->with('success', 'Berhasil mendupdate data material');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $material->delete();

        return back()->with('success', 'Berhasil menghapus data material');
    }
}
