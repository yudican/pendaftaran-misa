<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DataPendaftaranExport implements FromQuery, WithHeadings, WithMapping
{
    protected $jadwal_id = null;

    public function __construct($jadwal_id)
    {
        $this->jadwal_id = $jadwal_id;
    }

    public function query()
    {
        if ($this->jadwal_id) {
            return Pendaftaran::query()->where('jadwal_id', $this->jadwal_id);
        } else {
            return Pendaftaran::query();
        }
    }

    public function map($pendaftaran): array
    {
        $tanggal = date('Y-m-d', strtotime($pendaftaran->jadwal->tanggal)) . ' ' . $pendaftaran->jadwal->waktu;
        $status = 'Belum absen';
        if (strtotime(date('Y-m-d H:i:s')) >= strtotime($tanggal)) {
            $status = 'Belum absen';
        } else {
            if ($pendaftaran->status == 1) {
                $status = 'Hadir';
            } else {
                $status = 'Tidak Hadir';
            }
        }
        return [
            $pendaftaran->user->name,
            $pendaftaran->user->dataUmat->linkungan,
            $pendaftaran->user->dataUmat->wilayah,
            $pendaftaran->user->dataUmat->telepon . '\'',
            $status,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Lingkungan',
            'Wilayah',
            'Telepon',
            'Status',
        ];
    }
}
