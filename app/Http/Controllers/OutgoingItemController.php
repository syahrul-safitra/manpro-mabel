<?php

namespace App\Http\Controllers;

use App\Models\OutgoingItem;
use App\Models\Item;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class OutgoingItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.OutgoingItem.index', [
            'items' => OutgoingItem::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.OutgoingItem.create', [
            'items' => Item::select('nama', 'stok')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nama_barang' => 'required',
            'tanggal_keluar' => 'required|date',
            'jumlah' => ['required', 'integer', 'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    $item = Item::where('nama', $request->nama_barang)->first();
                    if ($item && $value > $item->stok) {
                        $fail('Jumlah melebihi stok yang tersedia.');
                    }
                },
            ],
        ]);
        // Simpan data barang keluar

        DB::transaction(function() use ($validatedData) {
            $outgoingItem = OutgoingItem::create($validatedData);

            // Update stok barang (opsional)
            $item = Item::where('nama', $validatedData['nama_barang'])->first();
            $item->stok -= $validatedData['jumlah'];
            $item->save();
        });

        return redirect('/outgoing-item')->with('success', 'Data barang keluar berhasil disimpan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(OutgoingItem $outgoingItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutgoingItem $outgoing_item)
    {
        return view('Admin.OutgoingItem.edit', [
            'item_lama' => $outgoing_item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OutgoingItem $outgoing_item)
    {
        // $selisihJumlah = $validatedData['jumlah'] - $outgoing_item->jumlah;
        $validatedData = $request->validate([
            'nama_barang' => 'required',
            'tanggal_keluar' => 'required|date',
            'jumlah' => 'required|integer|min:1',
        ]);

        $selisihJumlah = $validatedData['jumlah'] - $outgoing_item->jumlah;

        // Hitung selisih jumlah untuk update stok

        // Update stok barang
        $item = Item::where('nama', $validatedData['nama_barang'])->first();

        $item->stok -= $selisihJumlah;

        DB::beginTransaction();
        try {
            $outgoing_item->update($validatedData);
            $item->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('/outgoing-item')->with('error', 'Data barang keluar gagal diupdate.');
        }

        return redirect('/outgoing-item')->with('success', 'Data barang keluar berhasil diupdate.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutgoingItem $outgoing_item)
    {
        DB::beginTransaction();

        try {
            $item = Item::where('nama', $outgoing_item->nama_barang)->first();
            $item->stok += $outgoing_item->jumlah;
            $item->save();

            $outgoing_item->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('/outgoing-item')->with('error', 'Data barang keluar gagal dihapus.');
        }

        return redirect('/outgoing-item')->with('success', 'Data barang keluar berhasil dihapus.');
    }
}
