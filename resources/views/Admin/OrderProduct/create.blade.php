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
                        <h4 class="mb-0">Form Proses Produk</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/order') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Input Nama Pemesan -->
                            <div class="form-group">
                                <label for="nama_customer">Nama Customer</label>
                                <input type="text" class="form-control @error('nama_customer') is-invalid @enderror"
                                    id="nama_customer" name="nama_customer" placeholder="Masukkan nama customer"
                                    value="{{ old('nama_customer') }}">
                                @error('nama_customer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Input Nama Produk -->
                            <div class="form-group">
                                <label for="nama_produk">Nama Produk</label>
                                <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                                    id="nama_produk" name="nama_produk" placeholder="Masukkan nama produk"
                                    value="{{ old('nama_produk') }}">
                                @error('nama_produk')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Input Ukuran -->
                            <div class="form-group">
                                <label for="ukuran">Ukuran</label>
                                <input type="text" class="form-control @error('ukuran') is-invalid @enderror"
                                    id="ukuran" name="ukuran" placeholder="Contoh: 20x30 cm, L, XL, dll"
                                    value="{{ old('ukuran') }}">
                                @error('ukuran')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Input Biaya -->
                            <div class="form-group">
                                <label for="biaya_pembuatan">Biaya Pembuatan (RP)</label>
                                <input type="text" class="form-control @error('biaya_pembuatan') is-invalid @enderror"
                                    id="biaya_pembuatan" name="biaya_pembuatan" placeholder="Contoh: 1000000"
                                    value="{{ old('biaya_pembuatan') }}">
                                @error('biaya_pembuatan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Input Desain -->
                            <div class="form-group">
                                <label for="desain">Desain</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('desain') is-invalid @enderror"
                                        id="gambar" name="desain" accept="image/*,.pdf">
                                    <label class="custom-file-label" for="desain">Pilih file desain...</label>
                                </div>

                                <div class="mt-2">
                                    <img id="preview-gambar" src="#" alt="Preview Gambar"
                                        class="img-thumbnail d-none" style="max-height: 200px;">
                                </div>

                                @error('desain')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Input Tanggal Mulai -->
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai</label>
                                <input type="date" class="form-control @error('waktu_mulai') is-invalid @enderror"
                                    id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai') }}">
                                @error('waktu_mulai')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Input Tanggal Selesai -->
                            <div class="form-group">
                                <label for="tanggal_selesai">Tanggal Selesai</label>
                                <input type="date" class="form-control @error('waktu_selesai') is-invalid @enderror"
                                    id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai') }}">
                                @error('waktu_selesai')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Tombol Submit -->
                            <div class="form-group text-right">
                                <a href="{{ url('/order') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script>
        // Script untuk menampilkan nama file di input file
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;

            // Preview gambar
            previewGambar(e);
        });

        function previewGambar(event) {
            const input = event.target;
            const preview = document.getElementById('preview-gambar');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = "#";
                preview.classList.add('d-none');
            }
        }
    </script>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        #preview-container {
            background-color: #f8f9fa;
        }
    </style>
@endpush
