<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.Item.index', [
            'items' => Item::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Item.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validatedData = $request->validate([
            'nama' => 'required|string|unique:items|max:255',
            'deskripsi' => 'required|nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
            'stok' => 'required|integer|min:0',
        ]);

        $locationFile = "File";

        $file = $request->file('gambar');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($locationFile, $filename);
        $validatedData['gambar'] = $filename;

        // Simpan data produk ke database
        Item::create($validatedData);

        return redirect('item')->with('success', 'Item berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        return view('Admin.Item.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $data = [
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
            'stok' => 'required|integer|min:0',
        ];

        if($request->nama != $item->nama) {
            $data['nama'] = 'required|string|unique:items|max:255';
        }

        $validatedData = $request->validate($data);

        if ($request->hasFile('gambar')) {
            $locationFile = "File";

            $file = $request->file('gambar');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($locationFile, $filename);
            $validatedData['gambar'] = $filename;

            File::delete('File/' . $item->gambar);
        }
        

        $item->update($validatedData);

        return redirect('item')->with('success', 'Item berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        File::delete('File/' . $item->gambar);
        $item->delete();
        return redirect('item')->with('success', 'Item berhasil dihapus!');
    }
}
