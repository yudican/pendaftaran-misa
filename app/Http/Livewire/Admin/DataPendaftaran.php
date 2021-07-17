<?php

namespace App\Http\Livewire\Admin;

use App\Models\Jadwal;
use App\Models\Pendaftaran;
use Livewire\Component;


class DataPendaftaran extends Component
{

    public $jadwal_id;

    public function render()
    {
        return view('livewire.admin.pendaftaran', [
            'items' => Pendaftaran::all(),
            'jadwals' => Jadwal::all()
        ]);
    }

    public function filterData($value)
    {
        $this->emit('setFilter', ['jadwal_id' => $value]);
    }
}
