@extends("Layouts.main")
@section("container")
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                @if (session()->has("success"))
                    <div class="alert alert-success" role="alert">
                        {{ session("success") }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Form Edit Barang Keluar</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url("outgoing-item/" . $item_lama->id) }}" method="POST">
                            @csrf
                            @method("PUT")

                            <!-- Input Nama Barang (Select2) -->
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang</label>
                                <select class="form-control @error("nama_barang") is-invalid @enderror" id="nama_barang"
                                    name="nama_barang">
                                    <option value="{{ $item_lama->nama_barang }}">{{ $item_lama->nama_barang }}</option>

                                </select>
                                @error("nama_barang")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Input Tanggal Keluar -->
                            <div class="form-group">
                                <label for="tanggal_keluar">Tanggal Keluar</label>
                                <input type="date" class="form-control @error("tanggal_keluar") is-invalid @enderror"
                                    id="tanggal_keluar" name="tanggal_keluar"
                                    value="{{ old("tanggal_keluar", $item_lama->tanggal_keluar) }}">
                                @error("tanggal_keluar")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Input Jumlah -->
                            <div class="form-group">
                                <label for="jumlah">Jumlah</label>
                                <input type="number" class="form-control @error("jumlah") is-invalid @enderror"
                                    id="jumlah" name="jumlah" placeholder="Masukkan jumlah barang"
                                    value="{{ old("jumlah", $item_lama->jumlah) }}" min="1">
                                @error("jumlah")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Tombol Submit -->
                            <div class="form-group text-right">
                                <a href="{{ url("received-item") }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("styles")
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 Bootstrap4 Theme -->
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.4.0/dist/select2-bootstrap4.min.css"
        rel="stylesheet" />
@endpush

@push("scripts")
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
