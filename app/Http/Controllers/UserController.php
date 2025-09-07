<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.User.index', [
            'users' => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.User.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:200', 
            'email' => 'required|max:50|email:dns|unique:users',
            'password' => 'required|max:20'
        ]);

        User::create($validated);

        return redirect('users')->with('success', 'Berhasil menambahkan tukang');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('Admin.User.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|max:200',
            'password' => 'required|max:20'
        ];

        if ($user->email != $request->email) {
            $rules['email'] = 'required|max:50|email:dns|unique:users';
        }

        $validated = $request->validate($rules);

        $user->update($validated);

        return redirect('/users')->with('Success', 'Berhasil mengupdate user');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'Berhasil menghapus data user');
    }
}
