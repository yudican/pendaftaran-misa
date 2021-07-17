<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DataAbsenExport implements FromQuery, WithHeadings, WithMapping
{
    protected $jadwal_id = null;

    public function __construct($jadwal_id)
    {
        $this->jadwal_id = $jadwal_id;
    }

    public function query()
    {
        if ($this->jadwal_id) {
            return Pendaftaran::query()->where(['jadwal_id' => $this->jadwal_id, 'status' => '1']);
        } else {
            return Pendaftaran::query()->where(['status' => '1']);
        }
    }

    public function map($pendaftaran): array
    {
        return [
            $pendaftaran->user->name,
            $pendaftaran->user->dataUmat->linkungan,
            $pendaftaran->user->dataUmat->wilayah,
            $pendaftaran->user->dataUmat->telepon . '\'',
            $pendaftaran->jadwal->tanggal->isoFormat('dddd, D MMMM Y'),
        ];
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Lingkungan',
            'Wilayah',
            'Telepon',
            'Tanggal Misa'
        ];
    }
}
