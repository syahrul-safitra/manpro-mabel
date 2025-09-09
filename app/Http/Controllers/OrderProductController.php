<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use App\Models\Worker;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;

use Codedge\Fpdf\Fpdf\Fpdf;

class OrderProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.OrderProduct.index', [
            'orders' => OrderProduct::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.OrderProduct.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'nama_customer' => 'required|string|max:255',
            'ukuran' => 'required|string|max:100',
            'deskripsi' => 'string|max:245',
            'desain' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048', // max 2MB
            'biaya_pembuatan' => 'required|numeric',
            'waktu_mulai' => 'required|date',
            'waktu_tenggat' => 'required|date|after_or_equal:waktu_mulai',
        ]);

        // Handle upload desain
        if ($request->hasFile('desain')) {
            $desain = $request->file('desain');
            $desainName = uniqid() . $desain->getClientOriginalName();
            $location = 'File';
            $desain->move($location, $desainName);
            $validatedData['desain'] = $desainName;
        }

        // Simpan data proses
        OrderProduct::create($validatedData);

        return redirect('/order')->with('success', 'Berhasil menambahkan order');

    }

    /**
     * Display the specified resource.
     */
    public function show(OrderProduct $orderProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderProduct $order)
    {
        return view('Admin.OrderProduct.edit', [
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderProduct $order)
    {

        // $validatedData = $request->validate([
        //     'nama_produk' => 'required|string|max:255',
        //     'nama_customer' => 'required|string|max:255',
        //     'ukuran' => 'required|string|max:100',
        //     'desain' => 'file|mimes:jpeg,png,jpg,pdf|max:2048', // max 2MB
        //     'biaya_pembuatan' => 'required|numeric',
        //     'waktu_mulai' => 'required|date',
        //     'waktu_tenggat' => 'required|date|after_or_equal:waktu_mulai',
        //     'waktu_selesai' => '',
        //     'progress' => 'required|numeric|max:100',
        //     'selesai' => 'required'
        // ]);

        $rules = [
            'nama_produk' => 'required|string|max:255',
            'nama_customer' => 'required|string|max:255',
            'ukuran' => 'required|string|max:100',
            'desain' => 'file|mimes:jpeg,png,jpg,pdf|max:2048', // max 2MB
            'deskripsi' => 'string|max:245',
            'biaya_pembuatan' => 'required|numeric',
            'waktu_mulai' => 'required|date',
            'waktu_tenggat' => 'required|date|after_or_equal:waktu_mulai',
            'waktu_selesai' => '',
            'progress' => 'required|numeric|max:100',
            'selesai' => 'required'
        ];

        if ($request->waktu_selesai) {
            $rules['waktu_selesai'] = 'required|date|after_or_equal:waktu_mulai';
        }

        $validatedData = $request->validate($rules);

        // Handle upload desain
        if ($request->hasFile('desain')) {
            $desain = $request->file('desain');
            $desainName = uniqid() . $desain->getClientOriginalName();
            $location = 'File';
            $desain->move($location, $desainName);
            $validatedData['desain'] = $desainName;
            File::delete('File/' . $order->desain);
        }

        // Simpan data proses
        $order->update($validatedData);

        return redirect('/order')->with('success', 'Berhasil mengedit data order');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderProduct $order)
    {
        File::delete('File/' . $order->desain);
        File::delete('File/' . $order->gambar_proses);

        $order->delete();
    }

    public function dashboard() {
     
        $jumlahOrder = OrderProduct::count();
        $prosesOrder = OrderProduct::where('selesai', 0)->count();
        $selesaiOrder = OrderProduct::where('selesai', 1)->count();
        $tukang = Worker::count();

        return view('Admin.dashboard', [
            'jumlahOrder' => $jumlahOrder,
            'prosesOrder' => $prosesOrder,
            'selesaiOrder' => $selesaiOrder,
            'tukang' => $tukang
        ]);
    }

    public function detail(OrderProduct $order ) {
        
        // return $order->load('material.item', 'worker.user', 'comment.user');

        return view('Admin.OrderProduct.detail', [
            'order' => $order->load('material.item', 'worker.user', 'comment.user')
        ]);
    }

    public function updateProgress(OrderProduct $order, Request $request) {
        $validated = $request->validate([
            'progress' => 'required|max:100|numeric',
            'gambar_proses' => 'max:2100'
        ]);

        if ($request->hasFile('gambar_proses')) {
            $gambar = $request->file('gambar_proses');
            $gambarName = uniqid() . $gambar->getClientOriginalName();
            $location = 'File';
            $gambar->move($location, $gambarName);
            $validated['gambar_proses'] = $gambarName;
            File::delete('File/' . $order->gambar_proses);
        }

        $order->update($validated);

        return back()->with('success', 'Berhasil mengupdate progress');

    }

    public function invoice(OrderProduct $order) {

        $order->load('material.item', 'worker.user');

        // $workers = $order->worker;
        $materials = $order->material;

        // $order = [
        //     'nama_produk'     => 'Lemari Kayu Jati',
        //     'nama_customer'   => 'Siti Aisyah',
        //     'biaya_pembuatan' => 2500000,
        //     'ukuran'          => '200 x 80 x 50 cm',
        //     'waktu_mulai'     => '2025-09-01',
        //     'waktu_tenggat'   => '2025-09-15',
        //     'waktu_selesai'   => '2025-09-12',
        // ];

        // $materials = [
        //     ['nama' => 'Kayu Jati', 'jumlah' => 10, 'harga' => 150000],
        //     ['nama' => 'Engsel & Baut', 'jumlah' => 5, 'harga' => 20000],
        //     ['nama' => 'Cat Kayu', 'jumlah' => 2, 'harga' => 80000],
        // ];

        $pdf = new Fpdf();
        $pdf->AddPage();

        // === Header dengan Logo + Nama Usaha ===
        $pdf->SetFont('Arial', 'B', 20);

        // Tentukan posisi Y untuk logo & teks
        $y = 10;

        // === Header dengan Logo + Nama Usaha ===
        $pdf->SetFont('Arial', 'B', 20);

        // Tentukan posisi Y
        $y = 10;

        // Logo (misal lebar 20 mm), posisinya di tengah agak ke kiri
        $pdf->Image(public_path('FE/img/logo.png'), 60, $y, 20);

        // Geser posisi X untuk teks "Mebel Kito"
        $pdf->SetXY(85, $y + 5); 
        $pdf->Cell(40, 10, 'Mebel Pak Eko', 0, 1, 'L'); // rata kiri relatif ke logo

        // Alamat & kontak rata tengah
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, 'Jl. Merdeka No.123, Jambi', 0, 1, 'C');
        $pdf->Cell(0, 6, 'Telp: 0741-123456 | Email: info@mebelkito.com', 0, 1, 'C');

        // Garis tipis bawah header
        $pdf->Ln(2);
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
        $pdf->Ln(8);


        // Judul Invoice
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'INVOICE PESANAN', 0, 1, 'C');
        $pdf->Ln(5);

        // === Detail Order ===
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(95, 7, 'Nama Customer : ' . $order->nama_customer, 0, 0);
        $pdf->Cell(95, 7, 'Produk : ' . $order->nama_produk, 0, 1);
        $pdf->Cell(95, 7, 'Ukuran : ' . $order->ukuran, 0, 0);
        $pdf->Cell(95, 7, 'Biaya Pembuatan : Rp ' . number_format($order->biaya_pembuatan, 0, ',', '.'), 0, 1);
        $pdf->Cell(95, 7, 'Waktu Mulai : ' . date('d-m-Y', strtotime($order->waktu_mulai)), 0, 0);
        $pdf->Cell(95, 7, 'Waktu Selesai : ' . date('d-m-Y', strtotime($order->waktu_selesai)), 0, 1);
        $pdf->Cell(95, 7, 'Waktu Tenggat : ' . date('d-m-Y', strtotime($order->waktu_tenggat)), 0, 1);
        $pdf->Ln(8);

        // === Tabel Material ===
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 8, 'Material', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Jumlah', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Harga', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Total', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 12);
        $grandTotal = $order->biaya_pembuatan;
        foreach ($materials as $m) {

            $getItem = $m->item;

            $total = $m->jumlah * $getItem->harga_jual;
            $grandTotal += $total;

            $pdf->Cell(100, 8, $getItem->nama, 1);
            $pdf->Cell(30, 8, $m->jumlah, 1, 0, 'R');
            $pdf->Cell(30, 8, 'Rp ' . number_format($m->item->harga_jual, 0, ',', '.'), 1, 0, 'R');
            $pdf->Cell(30, 8, 'Rp ' . number_format($total, 0, ',', '.'), 1, 1, 'R');
        }

        // === Grand Total ===
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(160, 8, 'Grand Total', 1);
        $pdf->Cell(30, 8, 'Rp ' . number_format($grandTotal, 0, ',', '.'), 1, 1, 'R');

        $pdf->Ln(15);

        // Footer tanda tangan
        // $pdf->SetFont('Arial', '', 12);
        // $pdf->Cell(120, 6, '', 0, 0);
        // $pdf->Cell(70, 6, 'Jambi, ' . date('d-m-Y'), 0, 1, 'C');
        // $pdf->Cell(120, 20, '', 0, 0);
        // $pdf->Cell(70, 20, 'Mebel Kito', 0, 1, 'C');
        // $pdf->Cell(120, 6, '', 0, 0);
        // $pdf->Cell(70, 6, '(..........................)', 0, 1, 'C');

        $pdf->Output('I', 'Invoice_' . $order['nama_produk'] . '.pdf');
        exit;
    }
}
