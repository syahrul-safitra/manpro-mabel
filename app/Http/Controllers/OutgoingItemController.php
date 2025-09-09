<?php

namespace App\Http\Controllers;

use App\Models\OutgoingItem;
use App\Models\Item;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Codedge\Fpdf\Fpdf\Fpdf;

class OutgoingItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.OutgoingItem.index', [
            'items' => OutgoingItem::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.OutgoingItem.create', [
            'items' => Item::select('nama', 'stok')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nama_barang' => 'required',
            'tanggal_keluar' => 'required|date',
            'jumlah' => ['required', 'integer', 'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    $item = Item::where('nama', $request->nama_barang)->first();
                    if ($item && $value > $item->stok) {
                        $fail('Jumlah melebihi stok yang tersedia.');
                    }
                },
            ],
        ]);
        // Simpan data barang keluar

        DB::transaction(function() use ($validatedData) {
            $outgoingItem = OutgoingItem::create($validatedData);

            // Update stok barang (opsional)
            $item = Item::where('nama', $validatedData['nama_barang'])->first();
            $item->stok -= $validatedData['jumlah'];
            $item->save();
        });

        return redirect('/outgoing-item')->with('success', 'Data barang keluar berhasil disimpan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(OutgoingItem $outgoingItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutgoingItem $outgoing_item)
    {
        return view('Admin.OutgoingItem.edit', [
            'item_lama' => $outgoing_item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OutgoingItem $outgoing_item)
    {
        // $selisihJumlah = $validatedData['jumlah'] - $outgoing_item->jumlah;
        $validatedData = $request->validate([
            'nama_barang' => 'required',
            'tanggal_keluar' => 'required|date',
            'jumlah' => 'required|integer|min:1',
        ]);

        $selisihJumlah = $validatedData['jumlah'] - $outgoing_item->jumlah;

        // Hitung selisih jumlah untuk update stok

        // Update stok barang
        $item = Item::where('nama', $validatedData['nama_barang'])->first();

        $item->stok -= $selisihJumlah;

        DB::beginTransaction();
        try {
            $outgoing_item->update($validatedData);
            $item->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('/outgoing-item')->with('error', 'Data barang keluar gagal diupdate.');
        }

        return redirect('/outgoing-item')->with('success', 'Data barang keluar berhasil diupdate.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutgoingItem $outgoing_item)
    {
        DB::beginTransaction();

        try {
            $item = Item::where('nama', $outgoing_item->nama_barang)->first();
            $item->stok += $outgoing_item->jumlah;
            $item->save();

            $outgoing_item->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('/outgoing-item')->with('error', 'Data barang keluar gagal dihapus.');
        }

        return redirect('/outgoing-item')->with('success', 'Data barang keluar berhasil dihapus.');
    }

    public function invoice(Request $request)
    {

        $barangKeluar = OutgoingItem::with('item')->whereBetween('tanggal_keluar', [$request->tanggal_awal, $request->tanggal_akhir])->get();

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
        $pdf->Cell(0, 10, 'INVOICE BARANG KELUAR', 0, 1, 'C');

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

        foreach ($barangKeluar as $b) {

            $getItem = $b->item;

            $total = $getItem->harga_jual * $b->jumlah;
            $grandTotal += $total;

            $pdf->Cell(60, 8, $getItem->nama, 1);
            $pdf->Cell(30, 8, $b->tanggal_keluar, 1, 0, 'C');
            $pdf->Cell(30, 8, 'Rp ' . number_format($getItem->harga_jual, 0, ',', '.'), 1, 0, 'R');
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
