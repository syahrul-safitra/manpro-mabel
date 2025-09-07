@extends('Layouts.main')
@section('container')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Form Tambah Tukang</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('users') }}" method="POST">
                            @csrf

                            <!-- Input Name -->
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Masukkan nama lengkap"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>

                            <!-- Input Email -->
                            <div class="form-group">
                                <label for="email">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Masukkan email"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Input Password -->
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="text" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Masukkan password">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">Password maksimal 20 karakter</small>
                            </div>

                            <div class="">
                                <a href="{{ url('users') }}" class="btn btn-primary ">Kembali</a>
                                <button type="submit" class="btn btn-primary ">Daftar</button>
                            </div>
                        </form>
                    </div>
                    {{-- <div class="card-footer text-center">
                            <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
                        </div> --}}
                </div>
            </div>


        </div>
    </div>
@endsection
