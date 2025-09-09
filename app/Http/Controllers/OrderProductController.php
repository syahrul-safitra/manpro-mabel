<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;

class OrderProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.OrderProduct.index', [
            'orders' => OrderProduct::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.OrderProduct.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'nama_customer' => 'required|string|max:255',
            'ukuran' => 'required|string|max:100',
            'deskripsi' => 'string|max:245',
            'desain' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048', // max 2MB
            'biaya_pembuatan' => 'required|numeric',
            'waktu_mulai' => 'required|date',
            'waktu_tenggat' => 'required|date|after_or_equal:waktu_mulai',
        ]);

        // Handle upload desain
        if ($request->hasFile('desain')) {
            $desain = $request->file('desain');
            $desainName = uniqid() . $desain->getClientOriginalName();
            $location = 'File';
            $desain->move($location, $desainName);
            $validatedData['desain'] = $desainName;
        }

        // Simpan data proses
        OrderProduct::create($validatedData);

        return redirect('/order')->with('success', 'Berhasil menambahkan order');

    }

    /**
     * Display the specified resource.
     */
    public function show(OrderProduct $orderProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderProduct $order)
    {
        return view('Admin.OrderProduct.edit', [
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderProduct $order)
    {

        // $validatedData = $request->validate([
        //     'nama_produk' => 'required|string|max:255',
        //     'nama_customer' => 'required|string|max:255',
        //     'ukuran' => 'required|string|max:100',
        //     'desain' => 'file|mimes:jpeg,png,jpg,pdf|max:2048', // max 2MB
        //     'biaya_pembuatan' => 'required|numeric',
        //     'waktu_mulai' => 'required|date',
        //     'waktu_tenggat' => 'required|date|after_or_equal:waktu_mulai',
        //     'waktu_selesai' => '',
        //     'progress' => 'required|numeric|max:100',
        //     'selesai' => 'required'
        // ]);

        $rules = [
            'nama_produk' => 'required|string|max:255',
            'nama_customer' => 'required|string|max:255',
            'ukuran' => 'required|string|max:100',
            'desain' => 'file|mimes:jpeg,png,jpg,pdf|max:2048', // max 2MB
            'deskripsi' => 'string|max:245',
            'biaya_pembuatan' => 'required|numeric',
            'waktu_mulai' => 'required|date',
            'waktu_tenggat' => 'required|date|after_or_equal:waktu_mulai',
            'waktu_selesai' => '',
            'progress' => 'required|numeric|max:100',
            'selesai' => 'required'
        ];

        if ($request->waktu_selesai) {
            $rules['waktu_selesai'] = 'required|date|after_or_equal:waktu_mulai';
        }

        $validatedData = $request->validate($rules);

        // Handle upload desain
        if ($request->hasFile('desain')) {
            $desain = $request->file('desain');
            $desainName = uniqid() . $desain->getClientOriginalName();
            $location = 'File';
            $desain->move($location, $desainName);
            $validatedData['desain'] = $desainName;
            File::delete('File/' . $order->desain);
        }

        // Simpan data proses
        $order->update($validatedData);

        return redirect('/order')->with('success', 'Berhasil mengedit data order');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderProduct $order)
    {
        File::delete('File/' . $order->desain);
        File::delete('File/' . $order->gambar_proses);

        $order->delete();
    }

    public function detail(OrderProduct $order ) {
        
        // return $order->load('material.item', 'worker.user', 'comment.user');

        return view('Admin.OrderProduct.detail', [
            'order' => $order->load('material.item', 'worker.user', 'comment.user')
        ]);
    }

    public function updateProgress(OrderProduct $order, Request $request) {
        $validated = $request->validate([
            'progress' => 'required|max:100|numeric',
            'gambar_proses' => 'max:2100'
        ]);

        if ($request->hasFile('gambar_proses')) {
            $gambar = $request->file('gambar_proses');
            $gambarName = uniqid() . $gambar->getClientOriginalName();
            $location = 'File';
            $gambar->move($location, $gambarName);
            $validated['gambar_proses'] = $gambarName;
            File::delete('File/' . $order->gambar_proses);
        }

        $order->update($validated);

        return back()->with('success', 'Berhasil mengupdate progress');

    }
}
