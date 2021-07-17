<?php

namespace App\Http\Livewire\Admin;

use App\Models\Jadwal;
use Livewire\Component;

class CatatanKehadiran extends Component
{
    public $tanggal_mulai;
    public $tanggal_selesai;

    public function render()
    {
        return view('livewire.admin.catatan-kehadiran', [
            'jadwals' => Jadwal::all()
        ]);
    }

    public function setFilter()
    {
        $this->emit('setFilter', [
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
        ]);
    }
}
