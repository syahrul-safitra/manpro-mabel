<?php

namespace App\Http\Controllers;

use App\Models\ReceivingItem;
use App\Models\Item;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Codedge\Fpdf\Fpdf\Fpdf;

class ReceivingItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.ReceivedItem.index', [
            'items' => ReceivingItem::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('Admin.ReceivedItem.create', [
            'items' => Item::select('nama')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required',
            'tanggal_masuk' => 'required|date',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Simpan data barang masuk

        DB::transaction(function() use ($validatedData) {
            $receivingItem = ReceivingItem::create($validatedData);

            // Update stok barang (opsional)
            $item = Item::where('nama', $validatedData['nama_barang'])->first();
            $item->stok += $validatedData['jumlah'];
            $item->save();
        });

        return redirect('/received-item')->with('success', 'Data barang masuk berhasil disimpan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(ReceivingItem $receivingItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReceivingItem $received_item)
    {

        return view('Admin.ReceivedItem.edit', [
            'item_lama' => $received_item,
            'items' => Item::select('nama')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReceivingItem $received_item)
    {

        $validatedData = $request->validate([
            'nama_barang' => 'required',
            'tanggal_masuk' => 'required|date',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Hitung selisih jumlah untuk update stok
        $selisihJumlah = $validatedData['jumlah'] - $received_item->jumlah;

        // Update stok barang
        $item = Item::where('nama', $validatedData['nama_barang'])->first();

        $item->stok += $selisihJumlah;

        DB::beginTransaction();

        try {
            $received_item->update($validatedData);
            $item->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('/received-item')->with('error', 'Data barang masuk gagal diupdate.');
        }

        return redirect('/received-item')->with('success', 'Data barang masuk berhasil diupdate.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReceivingItem $received_item)
    {

        DB::beginTransaction();

        try {
            $item = Item::where('nama', $received_item->nama_barang)->first();
            $item->stok -= $received_item->jumlah;
            $item->save();

            $received_item->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('/received-item')->with('error', 'Data barang masuk gagal dihapus.');
        }

        return redirect('/received-item')->with('success', 'Data barang masuk berhasil dihapus.');
    }

    public function invoice(Request $request)
    {

        $barangMasuk = ReceivingItem::with('item')->whereBetween('tanggal_masuk', [$request->tanggal_awal, $request->tanggal_akhir])->get();

        $pdf = new Fpdf();
        $pdf->AddPage();

        // === Header dengan Logo + Nama Usaha ===
        $y = 10;
        $pdf->Image(public_path('FE/img/logo.png'), 60, $y, 20); // logo 20mm
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetXY(85, $y + 5);
        $pdf->Cell(40, 10, 'Mebel Pak Eko', 0, 1, 'L');

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, 'Jl. Merdeka No.123, Jambi', 0, 1, 'C');
        $pdf->Cell(0, 6, 'Telp: 0741-123456 | Email: info@mebelkito.com', 0, 1, 'C');

        $pdf->Ln(2);
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
        $pdf->Ln(8);

        // === Judul Dokumen ===
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'INVOICE BARANG MASUK', 0, 1, 'C');

        // Tambahkan periode
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, 'Periode: ' . date('d-m-Y', strtotime($request->tanggal_awal)) . ' s/d ' . date('d-m-Y', strtotime($request->tanggal_akhir)), 0, 1, 'C');
        $pdf->Ln(5);

        // === Header Tabel ===
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60, 8, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Tanggal', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Harga', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Jumlah', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Total Harga', 1, 1, 'C');

        // === Isi Tabel ===
        $pdf->SetFont('Arial', '', 12);
        $grandTotal = 0;

        foreach ($barangMasuk as $b) {

            $getItem = $b->item;

            $total = $getItem->harga_beli * $b->jumlah;
            $grandTotal += $total;

            $pdf->Cell(60, 8, $getItem->nama, 1);
            $pdf->Cell(30, 8, $b->tanggal_masuk, 1, 0, 'C');
            $pdf->Cell(30, 8, 'Rp ' . number_format($getItem->harga_beli, 0, ',', '.'), 1, 0, 'R');
            $pdf->Cell(30, 8, $b->jumlah, 1, 0, 'C');
            $pdf->Cell(40, 8, 'Rp ' . number_format($total, 0, ',', '.'), 1, 1, 'R');
        }

        // === Grand Total ===
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(150, 8, 'TOTAL KESELURUHAN', 1);
        $pdf->Cell(40, 8, 'Rp ' . number_format($grandTotal, 0, ',', '.'), 1, 1, 'R');

        $pdf->Ln(15);

        // // === Footer Tanda Tangan ===
        // $pdf->SetFont('Arial', '', 12);
        // $pdf->Cell(120, 6, '', 0, 0);
        // $pdf->Cell(70, 6, 'Jambi, ' . date('d-m-Y'), 0, 1, 'C');
        // $pdf->Cell(120, 20, '', 0, 0);
        // $pdf->Cell(70, 20, 'Mebel Kito', 0, 1, 'C');
        // $pdf->Cell(120, 6, '', 0, 0);
        // $pdf->Cell(70, 6, '(..........................)', 0, 1, 'C');

        $pdf->Output('I', 'Invoice_BarangMasuk.pdf');
        exit;
    }
}
