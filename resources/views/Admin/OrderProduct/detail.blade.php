@extends('Layouts.main')

<style>
    :root {
        --primary-dark: #0a2463;
        --primary-white: #ffffff;
        --accent-red: #d8315b;
        --light-bg: #f8f9fa;
        --card-light: #ffffff;
        --border-light: #dee2e6;
        --text-dark: #333333;
    }

    /* body {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            color: var(--text-dark);
            min-height: 100vh;
            padding: 40px 0;
        } */
    /* Detail Container */
    .detail-container {
        /* max-width: 1000px; */
        margin: 0 auto;
        padding: 0 20px;
        margin-bottom: 20px
    }

    /* Header Section */
    .detail-header {
        margin-bottom: 30px;
    }

    .detail-header h4 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Detail Card */
    .detail-card {
        background-color: var(--card-light);
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--border-light);
    }

    /* Success Alert */
    .success-alert {
        background-color: rgba(40, 167, 69, 0.1);
        border: 1px solid #28a745;
        color: #28a745;
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .alert-close {
        background: none;
        border: none;
        font-size: 1.2rem;
        color: #28a745;
        cursor: pointer;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-status {
        background-color: var(--primary-dark);
        color: var(--primary-white);
        border: none;
    }

    .btn-status:hover {
        background-color: #071a4a;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(10, 36, 99, 0.3);
    }

    .btn-payment {
        background-color: #17a2b8;
        color: var(--primary-white);
        border: none;
    }

    .btn-payment:hover {
        background-color: #138496;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(23, 162, 184, 0.3);
    }

    .btn-receipt {
        background-color: #28a745;
        color: var(--primary-white);
        border: none;
    }

    .btn-receipt:hover {
        background-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 15px;
        border: none;
    }

    .modal-header {
        border-bottom: 1px solid var(--border-light);
        padding: 20px;
    }

    .modal-title {
        font-weight: 600;
        color: var(--primary-dark);
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        border-top: 1px solid var(--border-light);
        padding: 20px;
    }

    /* Radio Buttons */
    .form-check {
        margin-bottom: 15px;
    }

    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.25em;
    }

    .form-check-input:checked {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    .form-check-label {
        font-weight: 500;
    }

    /* Detail Table */
    .detail-table {
        width: 100%;
        border-collapse: collapse;
    }

    .detail-table th {
        width: 30%;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: var(--primary-dark);
        border-bottom: 1px solid var(--border-light);
        vertical-align: top;
    }

    .detail-table td {
        width: 5%;
        padding: 12px 15px;
        border-bottom: 1px solid var(--border-light);
        vertical-align: top;
    }

    .detail-table td:last-child {
        width: 65%;
    }

    .detail-table tr:last-child th,
    .detail-table tr:last-child td {
        border-bottom: none;
    }

    /* Status Badges */
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-warning {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }

    .badge-info {
        background-color: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
    }

    .badge-success {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    /* Payment Proof */
    .payment-proof {
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-view-proof {
        background-color: #17a2b8;
        color: var(--primary-white);
        border: none;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }

    .btn-view-proof:hover {
        background-color: #138496;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .detail-header h4 {
            font-size: 1.3rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }

        .detail-table th,
        .detail-table td {
            padding: 10px;
            font-size: 0.9rem;
        }

        .detail-table th {
            width: 40%;
        }

        .detail-table td:last-child {
            width: 55%;
        }
    }

    /* Komentar */
</style>

@section('container')
    {{-- Detail Order --}}
    <div class="detail-container">
        <!-- Header -->
        <div class="detail-header">
            <h4><i class="bi bi-box-arrow-up"></i> Detail Pemesanan Mabel</h4>
        </div>

        {{-- =========================================================================================================================================================== --}}
        {{-- Detail Pemesanan --}}
        <!-- Detail Card -->
        <div class="detail-card">
            <!-- Success Alert -->

            @if (session()->has('success'))
                <div class="success-alert">
                    <div>
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button class="alert-close">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger">
                    <div>
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button class="alert-close">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">

                    <ul>

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-buttons">
                {{-- <button type="button" class="btn-action btn-status" data-bs-toggle="modal" data-bs-target="#statusModal">
                    <i class="bi bi-pencil-square"></i> Status Rental
                </button> --}}

                <a href="{{ url('/order') }}" class="btn-action btn-receipt">
                    Kembali
                </a>

                @if (!$order->selesai)
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#progressModal">
                        Form Progress
                    </button>
                @else
                    {{-- <button type="button" class="btn-action btn-payment" data-toggle="modal" data-target="#exampleModal">
                        INI JUGA MODAL
                    </button> --}}

                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#laporanModal">
                        Cetak Invoice
                    </button>
                @endif

            </div>

            <!-- Detail Table -->
            <table class="detail-table">
                <tbody>
                    <tr>
                        <th>Nama Customer</th>
                        <td>:</td>
                        <td>{{ $order->nama_customer }}</td>
                    </tr>

                    <tr>
                        <th>Nama Produk</th>
                        <td>:</td>
                        <td>{{ $order->nama_produk }}</td>
                    </tr>

                    <tr>
                        <th>Ukuran</th>
                        <td>:</td>
                        <td>{{ $order->ukuran }}</td>
                    </tr>

                    <tr>
                        <th>Biaya</th>
                        <td>:</td>
                        <td>{{ 'Rp ' . number_format($order->biaya, 0, ',', '.') }}</td>
                    </tr>

                    <tr>
                        <th>Desain</th>
                        <td>:</td>
                        <td><a href="{{ asset('File/' . $order->desain) }}" class="btn btn-sm btn-warning mr-1"
                                title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <th>Deskripsi</th>
                        <td>:</td>
                        <td>{{ $order->deskripsi }}
                        </td>
                    </tr>

                    <tr>
                        <th>Tanggal Mulai</th>
                        <td>:</td>
                        <td>{{ date('d-m-Y', strtotime($order->waktu_mulai)) }}
                        <td>
                    </tr>

                    <tr>
                        <th>Tanggal Tenggat</th>
                        <td>:</td>
                        <td>{{ date('d-m-Y', strtotime($order->waktu_tenggat)) }}
                        <td>
                    </tr>

                    <tr>
                        <th>Tanggal Selesai</th>
                        <td>:</td>
                        <td>{{ $order->waktu_selesai ? date('d-m-Y', strtotime($order->waktu_selesai)) : '' }}
                        <td>
                    </tr>
                    <tr>
                        <th>Status Pemesanan</th>
                        <td>:</td>
                        <td>
                            <span
                                class="badge {{ $order->selesai != '1' ? 'badge-warning' : 'badge-success' }}">{{ $order->selesai != '1' ? 'Belum Selesai' : 'Selesai' }}</span>

                        </td>
                    </tr>
                    <tr>
                        <th>Progress</th>
                        <td>:</td>
                        <td>
                            @if ($order->progress >= 63)
                                <span class="badge badge-success">{{ $order->progress }}</span>
                            @elseif($order->progress >= 33)
                                <span class="badge badge-warning">{{ $order->progress }}</span>
                            @else
                                <span class="badge badge-danger">{{ $order->progress }}</span>
                            @endif

                        </td>
                    </tr>

                    <tr>
                        <th>Gambar Progress</th>
                        <td>:</td>
                        <td>
                            @if ($order->gambar_proses)
                                <a href="{{ asset('File/' . $order->gambar_proses) }}" class="btn btn-sm btn-primary mr-1"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    {{-- <tr>
                        <th>Status Pembayaran</th>
                        <td>:</td>
                        <td>
                            <span
                                class="badge {{ $booking->status_pembayaran == 'belum_dikonfirmasi' ? 'badge-warning' : 'badge-success' }}">{{ $booking->status_pembayaran }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Total Denda</th>
                        <td>:</td>
                        <td>Rp. 35.000</td>
                    </tr>
                    <tr>
                        <th>Bukti Pembayaran</th>
                        <td>:</td>
                        <td>
                            <div class="payment-proof">
                                <a href="{{ asset('file/' . $booking->bukti_pembayaran) }}" class="btn-view-proof">
                                    <i class="bi bi-eye"></i> Lihat Bukti
                                </a>
                            </div>
                        </td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================================================================================================================================================================ --}}
    {{-- Materials --}}
    <div class="detail-container">
        <!-- Header -->
        <div class="detail-header">
            <h4><i class="bi bi-box-arrow-up"></i> Detail Material</h4>
        </div>

        <!-- Detail Card -->
        <div class="detail-card">

            <div class="action-buttons">

                @if (!$order->selesai)
                    <a href="{{ url('create-material/' . $order->id) }}" class="btn btn-info">
                        Tambah
                    </a>
                @endif

            </div>

            <div class="table-responsive">
                <table class="table-bordered table-hover table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($order->material as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->item->nama }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ 'Rp ' . number_format($item->jumlah * $item->item->harga_jual, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ url('edit-material/' . $item->id) }}"
                                            class="btn btn-sm btn-warning mr-1" style="height: 25px" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ url('destroy-material/' . $item->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus material ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-3 text-center">
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


    {{-- =========================================================================================================================================================================== --}}
    {{-- Detail Pekerja --}}
    <div class="detail-container">
        <!-- Header -->
        <div class="detail-header">
            <h4><i class="bi bi-box-arrow-up"></i> Detail Pekerja</h4>
        </div>

        <!-- Detail Card -->
        <div class="detail-card">

            <div class="action-buttons">

                @if (!$order->selesai)
                    <a href="{{ url('create-worker/' . $order->id) }}" class="btn btn-info">
                        Tambah
                    </a>
                @endif

            </div>

            <div class="table-responsive">
                <table class="table-bordered table-hover table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pekerja</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($order->worker as $worker)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $worker->user->name }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <form action="{{ url('destroy-worker/' . $worker->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus tukang ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-3 text-center">
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


    {{-- =========================================================================================================================================================================== --}}
    {{-- Diskusi --}}
    <div class="detail-container">
        <!-- Header -->
        <div class="detail-header">
            <h4><i class="bi bi-box-arrow-up"></i> Tanya Progress Pekrjaan</h4>
        </div>

        <div class="detail-card">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Progress Pengerjaan</h5>

                    <!-- Form input komentar -->
                    <form id="formKomentar" action="{{ url('/coment') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="user_id" value="1">
                        <input type="hidden" name="order_product_id" value="{{ $order->id }}">
                        <div class="input-group">
                            <input type="text" class="form-control rounded-left shadow-sm"
                                placeholder="💬 Tanyakan progress pekerjaan di sini..." name="pesan" id="inputKomentar"
                                max="230" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary rounded-right shadow-sm px-4" type="submit">
                                    <i class="fa fa-paper-plane"></i> Kirim
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Daftar komentar -->
                    <ul class="list-group list-group-flush" id="listKomentar">
                        @foreach ($order->comment as $item)
                            <li class="list-group-item">
                                {{-- <div class="d-flex justify-content-between align-items-center">
                                    <strong>{{ $item->user->name }}</strong>
                                    <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0">{{ $item->pesan }}</p> --}}

                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>{{ $item->user->name }}</strong> <br>
                                        <p class="mb-1">{{ $item->pesan }}</p>
                                        <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                    </div>

                                    @if (auth()->user()->id === $item->user->id)
                                        <form action="{{ url('destroy-comment/' . $item->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus komen ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger ml-2">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>

                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>


    </div>




    {{-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --}}
    <!-- Status Rental Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Status Rental</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <p>Ubah Status Rental</p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="statusRental" id="belumDiambil"
                                checked>
                            <label class="form-check-label" for="belumDiambil">
                                Belum Diambil
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="statusRental" id="sedangDipinjam">
                            <label class="form-check-label" for="sedangDipinjam">
                                Sedang Dipinjam
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="statusRental" id="telahDikembalikan">
                            <label class="form-check-label" for="telahDikembalikan">
                                Telah Dikembalikan
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================================================================================================================================== --}}
    {{-- Modal Edit Progress --}}
    <div class="modal fade" id="progressModal" tabindex="-1" role="dialog" aria-labelledby="progressModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="progressModalLabel">Atur Progress</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('update-progress-order/' . $order->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="progressRange">Nilai Progress: <span
                                    id="progressValue">{{ $order->progress }}</span>%</label>
                            <input type="range" class="form-control-range" name="progress" id="progressRange"
                                min="0" max="100" value="{{ $order->progress }}">
                        </div>
                        <div class="form-group">
                            <label for="imageUpload">Unggah Gambar</label>
                            <input type="file" class="form-control-file" name="gambar_proses" id="imageUpload"
                                accept=".jpg, .jpeg, .png">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="tanggalAwal">Tanggal Awal:</label>
                            <input type="date" class="form-control" id="tanggalAwal">
                        </div>
                        <div class="form-group">
                            <label for="tanggalAkhir">Tanggal Akhir:</label>
                            <input type="date" class="form-control" id="tanggalAkhir">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Lihat Laporan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Booking Modal -->
    <!-- Modal -->
    {{-- <div class="modal fade" id="statusBooking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Status Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('set-status-booking1/' . $booking->id) }}" method="POST">
                        @csrf
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status_booked" id="statusPending"
                                value="pending" @checked($booking->status_booking == 'pending')>
                            <label class="form-check-label" for="statusPending">
                                Pending
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status_booked" id="statusBooked"
                                value="booked" @checked($booking->status_booking == 'booked')>
                            <label class="form-check-label" for="statusBooked">
                                Booked
                            </label>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
                </form>
            </div>
        </div>
    </div> --}}

    <!-- Modal -->
    {{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('set-status-pembayaran1/' . $booking->id) }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Status Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Ubah Status Pembayaran</p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="belum_dikonfirmasi"
                                name="status_pembayaran" id="pending" required @checked($booking->status_pembayaran == 'belum_dikonfirmasi')>
                            <label class="form-check-label" for="pending">
                                Belum dikonfirmasi
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status_pembayaran"
                                value="sudah_dikonfirmasi" id="telahDibayar" required @checked($booking->status_pembayaran == 'sudah_dikonfirmasi')>
                            <label class="form-check-label" for="telahDibayar">
                                Sudah dikonfirmasi
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

    <script>
        // Ambil elemen input dan span
        const progressRange = document.getElementById('progressRange');
        const progressValue = document.getElementById('progressValue');

        // Tambahkan event listener untuk memperbarui nilai
        progressRange.addEventListener('input', function() {
            progressValue.textContent = this.value;
        });
    </script>
@endsection
