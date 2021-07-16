<?php

namespace App\Http\Livewire\Client;

use App\Models\Jadwal;
use App\Models\Pendaftaran;
use Livewire\Component;

class CekPendaftaran extends Component
{
    public $pendaftarans = [];
    public $jadwal_id;
    public function render()
    {
        return view('livewire.client.cek-pendaftaran', [
            'jadwals' => Jadwal::whereDate('tanggal', '>=', date('Y-m-d'))->get(),
        ])->layout('layouts.user');
    }

    public function cekPendaftaran($jadwal_id)
    {
        $this->jadwal_id = $jadwal_id;
        $this->pendaftarans = Pendaftaran::where(['jadwal_id'  => $jadwal_id])->get();
    }
}
