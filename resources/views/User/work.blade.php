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
                <h6 class="font-weight-bold text-primary m-0">List Pekerjaan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-bordered table-hover table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Akhir</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($worker as $work)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $work->orderProduct->nama_produk }}</td>
                                    <td>{{ date("d-m-Y", strtotime($work->orderProduct->waktu_mulai)) }}</td>
                                    <td>{{ date("d-m-Y", strtotime($work->orderProduct->waktu_tenggat)) }}</td>
                                    <td><span
                                            class="badge {{ $work->orderProduct->selesai ? "badge-success" : "badge-danger" }}">{{ $work->orderProduct->selesai ? "Selesai" : "Belum Selesai" }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ url("detail-working/" . $work->orderProduct->id) }}"
                                                class="btn btn-sm btn-info mr-1" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-3 text-center">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <p>Belum ada pekerjaan</p>
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
