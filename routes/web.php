<?php

use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReceivingItemController;
use App\Http\Controllers\OutgoingItemController;

use Illuminate\Support\Facades\Route;

use Codedge\Fpdf\Fpdf\Fpdf;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('Layouts.main');
})->middleware('isAdmin');



Route::get('/test', function() {
    return view('Layouts.main');
})->middleware('isAdmin');

Route::resource('/item', ItemController::class);
Route::resource('/received-item', ReceivingItemController::class);
Route::resource('/outgoing-item', OutgoingItemController::class);

Route::resource('/users', UserController::class);

Route::resource('/order', OrderProductController::class);

Route::get('detail-order/{order}', [OrderProductController::class, 'detail']);
Route::post('update-progress-order/{order}', [OrderProductController::class, 'updateProgress']);


Route::controller(MaterialController::class)->group(function() {
    Route::get('create-material/{order}', 'create');
    Route::get('edit-material/{material}', 'edit');
    Route::post('material', 'store');
    Route::post('material/{material}', 'update');
    Route::post('destroy-material/{material}', 'destroy');
});

Route::controller(WorkerController::class)->group(function() {
    Route::get('create-worker/{order}', 'create');
    Route::post('/worker', 'store');
    Route::post('destroy-worker/{worker}', 'destroy');
});

Route::controller(CommunicationController::class)->group(function() {
    Route::post('coment', 'store');
    Route::post('destroy-comment/{communication}', 'destroy');
});

Route::controller(AuthenticationController::class)->group(function() {
    Route::get('login', 'index')->name('login');
    Route::post('login', 'verify');
    Route::post('logout', 'logout');
});

// Route::get('/user-worker', [WorkerController::class, 'userWorker']);

Route::controller(WorkerController::class)->group(function() {
    Route::get('user-worker', 'userWorker');
    Route::get('detail-working/{order}', 'detailWorking');
});

Route::get('/is-user', function() {
    return auth()->user();
});

Route::get('/invoice', function() {
    // ==== DATA DUMMY ====
        $order = [
            'nama_produk'     => 'Lemari Kayu Jati',
            'nama_customer'   => 'Siti Aisyah',
            'biaya_pembuatan' => 2500000,
            'ukuran'          => '200 x 80 x 50 cm',
            'waktu_mulai'     => '2025-09-01',
            'waktu_tenggat'   => '2025-09-15',
            'waktu_selesai'   => '2025-09-12',
        ];

        $materials = [
            ['nama' => 'Kayu Jati', 'jumlah' => 10, 'harga' => 150000],
            ['nama' => 'Engsel & Baut', 'jumlah' => 5, 'harga' => 20000],
            ['nama' => 'Cat Kayu', 'jumlah' => 2, 'harga' => 80000],
        ];

        // ==== PDF ====
        $pdf = new Fpdf();
        $pdf->AddPage();

        // Header Mebel Kito
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(190, 10, 'Mebel Kito', 0, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(190, 6, 'Jl. Merdeka No.123, Jambi', 0, 1, 'C');
        $pdf->Cell(190, 6, 'Telp: 0741-123456 | Email: info@mebelkito.com', 0, 1, 'C');
        $pdf->Ln(5);

        // Judul Invoice
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(190, 10, 'INVOICE PESANAN', 0, 1, 'C');
        $pdf->Ln(5);

        // Detail Order
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(95, 7, 'Nama Customer : ' . $order['nama_customer'], 0, 0);
        $pdf->Cell(95, 7, 'Produk : ' . $order['nama_produk'], 0, 1);
        $pdf->Cell(95, 7, 'Ukuran : ' . $order['ukuran'], 0, 0);
        $pdf->Cell(95, 7, 'Biaya Pembuatan : Rp ' . number_format($order['biaya_pembuatan'], 0, ',', '.'), 0, 1);
        $pdf->Cell(95, 7, 'Waktu Mulai : ' . $order['waktu_mulai'], 0, 0);
        $pdf->Cell(95, 7, 'Waktu Tenggat : ' . $order['waktu_tenggat'], 0, 1);
        $pdf->Cell(95, 7, 'Waktu Selesai : ' . $order['waktu_selesai'], 0, 1);
        $pdf->Ln(8);

        // Tabel Material
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 8, 'Material', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Jumlah', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Harga', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Total', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 12);
        $grandTotal = $order['biaya_pembuatan'];
        foreach ($materials as $m) {
            $total = $m['jumlah'] * $m['harga'];
            $grandTotal += $total;

            $pdf->Cell(100, 8, $m['nama'], 1);
            $pdf->Cell(30, 8, $m['jumlah'], 1, 0, 'R');
            $pdf->Cell(30, 8, 'Rp ' . number_format($m['harga'], 0, ',', '.'), 1, 0, 'R');
            $pdf->Cell(30, 8, 'Rp ' . number_format($total, 0, ',', '.'), 1, 1, 'R');
        }

        // Grand Total
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(160, 8, 'Grand Total', 1);
        $pdf->Cell(30, 8, 'Rp ' . number_format($grandTotal, 0, ',', '.'), 1, 1, 'R');

        $pdf->Ln(15);

        // Footer tanda tangan
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(120, 6, '', 0, 0);
        $pdf->Cell(70, 6, 'Jambi, ' . date('d-m-Y'), 0, 1, 'C');
        $pdf->Cell(120, 20, '', 0, 0);
        $pdf->Cell(70, 20, 'Mebel Kito', 0, 1, 'C');
        $pdf->Cell(120, 6, '', 0, 0);
        $pdf->Cell(70, 6, '(..........................)', 0, 1, 'C');

        // Output
        $pdf->Output('I', 'Invoice_' . $order['nama_produk'] . '.pdf');
        exit;
});