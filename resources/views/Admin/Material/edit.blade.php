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
                        <h4 class="mb-0">Form Edit Material</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('material/' . $material->id) }}" method="POST">
                            @csrf

                            <input type="hidden" name="order_product_id" value="{{ $material->order_product_id }}">

                            <!-- Input Nama Barang (Select2) -->
                            <div class="form-group">
                                <label for="item_id">Nama Barang</label>
                                <select class="form-control @error('item_id') is-invalid @enderror" id="item_id"
                                    name="item_id" required>
                                    <option value="{{ $material->item_id }}">
                                        {{ $material->item->nama . ' (' . $material->item->stok . ')' }}</option>
                                </select>
                                @error('nama_barang')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <!-- Input Jumlah -->
                            <div class="form-group">
                                <label for="jumlah">Jumlah</label>
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                    id="jumlah" name="jumlah" placeholder="Masukkan jumlah barang"
                                    value="{{ old('jumlah', $material->jumlah) }}" min="1" required>
                                @error('jumlah')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Tombol Submit -->
                            <div class="form-group text-right">
                                <a href="{{ url('detail-order/' . $material->order_product_id) }}"
                                    class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 Bootstrap4 Theme -->
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.4.0/dist/select2-bootstrap4.min.css"
        rel="stylesheet" />
@endpush

@push('scripts')
    <!-- jQuery (required by Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2
            $('#nama_barang').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Barang --',
                allowClear: true
            });
        });
    </script>
@endpush
