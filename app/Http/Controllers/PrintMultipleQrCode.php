<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use PDF;

class PrintMultipleQrCode extends Controller
{
    public function cetak_barcode($jadwal_id, $limit = 0)
    {
        $pendaftaran = null;
        if ($limit > 0) {
            $pendaftaran = Pendaftaran::where(['jadwal_id'  => $jadwal_id])->limit($limit)->orderBy('created_at', 'DESC')->get();
        } else {
            $pendaftaran = Pendaftaran::where(['jadwal_id'  => $jadwal_id])->get();
        }

        $pdf = PDF::loadview('laporan.multi-barcode', ['pendaftarans' => $pendaftaran]);
        return $pdf->stream('barcode.pdf');
    }
}
