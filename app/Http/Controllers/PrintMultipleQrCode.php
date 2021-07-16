<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use PDF;

class PrintMultipleQrCode extends Controller
{
    public function cetak_barcode()
    {
        $pendaftaran = Pendaftaran::where(['parent_id'  => auth()->user()->dataUmat->id])->get();

        $pdf = PDF::loadview('laporan.multi-barcode', ['pendaftarans' => $pendaftaran]);
        return $pdf->stream('barcode.pdf');
    }
}