<?php

namespace App\Http\Controllers;

use App\Models\ReceivingItem;
use App\Models\Item;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;


class ReceivingItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.ReceivedItem.index', [
            'items' => ReceivingItem::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('Admin.ReceivedItem.create', [
            'items' => Item::select('nama')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validatedData = $request->validate([
            'nama_barang' => 'required',
            'tanggal_masuk' => 'required|date',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Simpan data barang masuk

        DB::transaction(function() use ($validatedData) {
            $receivingItem = ReceivingItem::create($validatedData);

            // Update stok barang (opsional)
            $item = Item::where('nama', $validatedData['nama_barang'])->first();
            $item->stok += $validatedData['jumlah'];
            $item->save();
        });

        return redirect('/received-item')->with('success', 'Data barang masuk berhasil disimpan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(ReceivingItem $receivingItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReceivingItem $receivingItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReceivingItem $receivingItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReceivingItem $receivingItem)
    {
        //
    }
}
