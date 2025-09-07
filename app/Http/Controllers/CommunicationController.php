<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use Illuminate\Http\Request;

class CommunicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'user_id' => 'required',
            'order_product_id' => 'required',
            'pesan' => 'required|max:250'
        ]);

        Communication::create($validated);

        return back()->with('success', 'Berhasil menambahkan komentar');

    }

    /**
     * Display the specified resource.
     */
    public function show(Communication $communication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Communication $communication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Communication $communication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Communication $communication)
    {
        //
    }
}
