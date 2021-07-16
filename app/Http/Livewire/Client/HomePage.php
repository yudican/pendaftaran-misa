<?php

namespace App\Http\Livewire\Client;

use App\Models\AbsenUmat;
use App\Models\DataAbsen;
use App\Models\Pendaftaran;
use Livewire\Component;

class HomePage extends Component
{
    public $result = null;
    public function render()
    {
        return view('livewire.client.home-page')->layout('layouts.user');
    }

    public function selectMenu($menu)
    {
        return redirect(route($menu));
    }

    public function cekUmat($result)
    {

        $pendaftaran = Pendaftaran::find($result);
        if (!$pendaftaran) {
            return $this->emit('showAlertError', ['msg' => 'Kamu Tidak Berhak mengikuti karena tidak terdaftar', 'status' => false]);
        }

        if ($pendaftaran->id == $result) {
            DataAbsen::updateOrCreate([
                'pendaftaran_id' => $result,
                'user_id' => $pendaftaran->user_id,
            ]);
            $this->emit('showAlert', ['msg' => 'Selamat Kamu Boleh Mengikuti Misa', 'status' => false]);
        }
        $this->result = $result;
    }
}
