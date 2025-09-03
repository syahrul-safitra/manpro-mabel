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
    public function edit(ReceivingItem $received_item)
    {

        return view('Admin.ReceivedItem.edit', [
            'item_lama' => $received_item,
            'items' => Item::select('nama')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReceivingItem $received_item)
    {

        $validatedData = $request->validate([
            'nama_barang' => 'required',
            'tanggal_masuk' => 'required|date',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Hitung selisih jumlah untuk update stok
        $selisihJumlah = $validatedData['jumlah'] - $received_item->jumlah;

        // Update stok barang
        $item = Item::where('nama', $validatedData['nama_barang'])->first();

        $item->stok += $selisihJumlah;

        DB::beginTransaction();

        try {
            $received_item->update($validatedData);
            $item->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('/received-item')->with('error', 'Data barang masuk gagal diupdate.');
        }

        return redirect('/received-item')->with('success', 'Data barang masuk berhasil diupdate.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReceivingItem $received_item)
    {

        DB::beginTransaction();

        try {
            $item = Item::where('nama', $received_item->nama_barang)->first();
            $item->stok -= $received_item->jumlah;
            $item->save();

            $received_item->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('/received-item')->with('error', 'Data barang masuk gagal dihapus.');
        }

        return redirect('/received-item')->with('success', 'Data barang masuk berhasil dihapus.');
    }
}
