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
                    <div class="card-header">
                        <h4 class="mb-0">Edit Produk</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/item/' . $item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Input Nama -->
                            <div class="form-group">
                                <label for="nama">Nama Produk</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" placeholder="Masukkan nama produk"
                                    value="{{ old('nama', $item->nama) }}" required>
                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Input Harga Beli -->
                            <div class="form-group">
                                <label for="harga_beli">Harga Beli (Rp)</label>
                                <input type="integer" class="form-control @error('harga_beli') is-invalid @enderror"
                                    id="harga_beli" name="harga_beli" placeholder="Masukkan harga_beli produk"
                                    value="{{ old('harga_beli', $item->harga_beli) }}">
                                @error('harga_beli')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Input Harga Jual -->
                            <div class="form-group">
                                <label for="harga_jual">Harga Beli (Rp)</label>
                                <input type="integer" class="form-control @error('harga_jual') is-invalid @enderror"
                                    id="harga_jual" name="harga_jual" placeholder="Masukkan harga_jual produk"
                                    value="{{ old('harga_jual', $item->harga_jual) }}">
                                @error('harga_jual')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Input Deskripsi -->
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4"
                                    placeholder="Masukkan deskripsi produk">{{ old('deskripsi', $item->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Input Gambar -->
                            <div class="form-group">
                                <label for="gambar">Gambar item</label>

                                <!-- Gambar Lama -->
                                @if ($item->gambar)
                                    <div class="mb-2">
                                        <p class="mb-1">Gambar Saat Ini:</p>
                                        <img src="{{ asset('File/' . $item->gambar) }}" alt="{{ $item->nama }}"
                                            class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                @endif

                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('gambar') is-invalid @enderror"
                                        id="gambar" name="gambar" accept="image/*">
                                    <label class="custom-file-label" for="gambar">Pilih file baru...</label>
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                                </div>

                                <!-- Preview Gambar Baru -->
                                <div class="mt-2">
                                    <img id="preview-gambar" src="{{ asset('File/' . $item->gambar) }}"
                                        alt="Preview Gambar Baru" class="img-thumbnail d-none" style="max-height: 200px;">
                                </div>

                                @error('gambar')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Input Stok -->
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                    id="stok" name="stok" placeholder="Masukkan jumlah stok"
                                    value="{{ old('stok', $item->stok) }}" min="0" readonly>
                                @error('stok')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Tombol Submit -->
                            <div class="form-group text-right">
                                <a href="{{ url('/item') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Update</button>
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
