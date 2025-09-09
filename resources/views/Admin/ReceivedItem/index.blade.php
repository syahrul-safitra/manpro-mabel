@extends("Layouts.main")

@section("container")
    <div class="container-fluid">
        <!-- DataTales Example -->
        @if (session()->has("success"))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session("success") }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h6 class="font-weight-bold text-primary m-0">Data Barang Masuk</h6>
                <div>
                    <a href="{{ url("received-item/create") }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Tambah Barang Masuk
                    </a>

                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#laporanModal">
                        Buat Laporan
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-bordered table-hover table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Nama Barang</th>
                                <th width="10%">Tanggal Masuk</th>
                                <th width="10%">Jumlah</th>
                                <th width="25%">Total</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_barang }}</td>
                                    <td>{{ date("d-m-Y", strtotime($item->tanggal_masuk)) }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ "Rp " . number_format($item->jumlah * $item->item->harga_beli, 0, ",", ".") }}
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ url("received-item/" . $item->id . "/edit") }}"
                                                class="btn btn-sm btn-warning mr-1" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ url("received-item/" . $item->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-3 text-center">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <p>Belum ada data produk</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="laporanModal" tabindex="-1" role="dialog" aria-labelledby="laporanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="laporanModalLabel">Filter Laporan Berdasarkan Tanggal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url("report-barang-masuk") }}" method="POST" target="_blank" id="reportForm">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="tanggalAwal">Tanggal Awal:</label>
                            <input type="date" class="form-control" name="tanggal_awal" id="tanggalAwal" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggalAkhir">Tanggal Akhir:</label>
                            <input type="date" class="form-control" name="tanggal_akhir" id="tanggalAkhir" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Lihat Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push("styles")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endpush

@push("scripts")
    <script>
        // Inisialisasi DataTable
        $(document).ready(function() {
            $('#dataTable').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
                }
            });
        });
    </script>
@endpush
