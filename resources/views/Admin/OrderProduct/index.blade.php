@extends('Layouts.main')

@section('container')
    <div class="container-fluid">
        <!-- DataTales Example -->
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h6 class="font-weight-bold text-primary m-0">Data Order</h6>
                <a href="{{ url('order/create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Tambah Pesanan
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-bordered table-hover table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Nama Produk</th>
                                <th width="5%">Ukuran</th>
                                <th width="10%">Tanggal Mulai</th>
                                <th width="10%">Tanggal Akhir</th>
                                <th width="10%">Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->nama_produk }}</td>
                                    <td>{{ $order->ukuran }}</td>
                                    <td>{{ date('d-m-Y', strtotime($order->waktu_mulai)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($order->waktu_tenggat)) }}</td>
                                    <td><span
                                            class="badge {{ $order->selesai === 1 ? 'badge-success' : 'badge-warning' }}">{{ $order->selesai === 1 ? 'Selesai' : 'Belum Selesai' }}</span>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">

                                            <a href="{{ url('order/' . $order->id . '/edit') }}"
                                                class="btn btn-sm btn-warning mr-1" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a href="{{ url('detail-order/' . $order->id) }}"
                                                class="btn btn-sm btn-info mr-1" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ url('order/' . $order->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus order, dan akan menghilangkan data yang berhubungan dengannya?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-3 text-center">
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
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endpush

@push('scripts')
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
