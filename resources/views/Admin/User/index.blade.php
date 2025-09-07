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
                <h6 class="font-weight-bold text-primary m-0">Data User</h6>
                <a href="{{ url('users/create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Tambah Tukang
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-bordered table-hover table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Nama</th>
                                <th width="35%">Email</th>
                                <th width="10%">Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->is_admin === 1 ? 'Admin' : 'Tukang' }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ url('users/' . $user->id . '/edit') }}"
                                                class="btn btn-sm btn-warning mr-1" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            @if ($user->is_admin !== 1)
                                                <form action="{{ url('users/' . $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user, dan akan menghilangkan data yang berhubungan dengannya?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif

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
