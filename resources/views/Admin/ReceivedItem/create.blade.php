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
                        <h4 class="mb-0">Form Barang Masuk</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url("received-item") }}" method="POST">
                            @csrf

                            <!-- Input Nama Barang (Select2) -->
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang</label>
                                <select class="form-control @error("nama_barang") is-invalid @enderror" id="nama_barang"
                                    name="nama_barang" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->nama }}"
                                            {{ old("nama_barang") == $item->nama ? "selected" : "" }}>
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error("nama_barang")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Input Tanggal Masuk -->
                            <div class="form-group">
                                <label for="tanggal_masuk">Tanggal Masuk</label>
                                <input type="date" class="form-control @error("tanggal_masuk") is-invalid @enderror"
                                    id="tanggal_masuk" name="tanggal_masuk"
                                    value="{{ old("tanggal_masuk", date("Y-m-d")) }}" required>
                                @error("tanggal_masuk")
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
                                    value="{{ old("jumlah") }}" min="1" required>
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
