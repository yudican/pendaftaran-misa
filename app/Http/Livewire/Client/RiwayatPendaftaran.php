<?php

namespace App\Http\Livewire\Client;

use App\Models\Pendaftaran;
use Livewire\Component;

class RiwayatPendaftaran extends Component
{
    public $pendaftaran_id;
    public $alasan;
    public function render()
    {
        return view('livewire.client.riwayat-pendaftaran', [
            'pendaftarans' => Pendaftaran::whereHas('jadwal', function ($query) {
                return $query->whereDate('tanggal', '>=', date('Y-m-d'));
            })->where('user_id', auth()->user()->id)->get()
        ])->layout('layouts.user');
    }

    public function getId($pendaftaran_id)
    {
        $pendaftaran = Pendaftaran::find($pendaftaran_id);
        $this->pendaftaran_id = $pendaftaran->id;

        $this->emit('showModal');
    }

    public function _reset()
    {
        $this->emit('closeModal');
        $this->pendaftaran_id = null;
        $this->alasan = null;
    }


    public function confirm()
    {
        $this->validate(['alasan' => 'required']);
        $pendaftaran = Pendaftaran::find($this->pendaftaran_id);
        $pendaftaran->update(['status' => '2', 'alasan' => $this->alasan]);

        $this->emit('showAlert', ['msg' => 'Pendaftaran Berhasil Dibatalkan']);
        $this->_reset();
    }
}
