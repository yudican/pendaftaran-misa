<?php

namespace App\Http\Livewire\Admin;

use App\Models\Jadwal;
use Livewire\Component;

class CatatanKehadiran extends Component
{
    public function render()
    {
        return view('livewire.admin.catatan-kehadiran', [
            'jadwals' => Jadwal::all()
        ]);
    }
}
