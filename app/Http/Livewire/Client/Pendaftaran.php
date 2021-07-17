<?php

namespace App\Http\Livewire\Client;

use App\Models\Jadwal;
use App\Models\Pendaftaran as ModelsPendaftaran;
use App\Models\Role;
use App\Models\StatusKesehatan;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;


class Pendaftaran extends Component
{

    public $pendaftaran_id;
    public $status;
    public $jadwal_id;
    public $jumlah_anggota;
    public $tab = 1;
    public $kuota = 0;
    public $username = [];
    public $status_kesehatan = [];
    public $data_umat = [];
    public $pendaftarans = [];
    public $jadwal;

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.client.pendaftaran', [
            'items' => ModelsPendaftaran::all(),
            'jadwals' => Jadwal::whereDate('tanggal', '>=', date('Y-m-d'))->orderBy('tanggal', 'ASC')->get(),
            'kesehatans' => StatusKesehatan::all(),
        ])->layout('layouts.user');
    }

    public function getForm($tab = 1, $validate = false)
    {
        if ($tab == 2 && $validate) {
            $this->validate([
                'jadwal_id' => 'required',
                'jumlah_anggota' => 'required',
            ]);
        }

        if ($tab == 3 && $validate) {
            for ($i = 0; $i < $this->jumlah_anggota; $i++) {
                $this->validate([
                    'username.' . $i => 'required',
                    'status_kesehatan.' . $i => 'required',
                ]);
            }

            foreach ($this->username as $key => $value) {
                $user = User::where('username', $this->username[$key])->first();

                if (!$user) {
                    $this->emit('showAlertError', ['msg' => 'Username ' . $this->username[$key] . ' Tidak Terdaftar']);
                    unset($this->username[$key]);

                    return 0;
                }

                $pendaftaran = ModelsPendaftaran::where(['user_id' => $user->id, 'jadwal_id' => $this->jadwal_id])->first();
                if ($pendaftaran) {
                    $this->emit('showAlertError', ['msg' => 'Username ' . $this->username[$key] . ' Sudah Terdaftar']);
                    unset($this->username[$key]);
                    unset($this->status_kesehatan[$key]);

                    return 0;
                }

                $this->data_umat[] = $user->dataUmat;
            }

            $jadwal = Jadwal::find($this->jadwal_id);
            $this->jadwal = $jadwal->tanggal->isoFormat('dddd, D MMMM Y');
        }


        $this->tab = $tab;
    }

    public function confirm()
    {

        foreach ($this->username as $key => $value) {
            $user = User::where('username', $this->username[$key])->first();

            $pendaftaran = ModelsPendaftaran::create(
                [
                    'jadwal_id' => $this->jadwal_id,
                    'user_id' => $user->id,
                    'status_kesehatan_id' => explode('.', $this->status_kesehatan[$key])[0],
                ]
            );

            $this->pendaftarans[] = $pendaftaran;
        }

        $this->tab = 4;
        $this->_reset();
        $this->emit('showAlert', ['msg' => 'Pendaftaran Berhasil']);
    }

    public function cekPendaftaran($jadwal_id)
    {
        $jadwal = Jadwal::find($jadwal_id);
        $this->kuota = $jadwal->kuota_tersedia - $jadwal->pendaftarans->count();
    }

    public function cekStatus($status_kesehatan_id)
    {
        $status = explode('.', $status_kesehatan_id);
        $kesehatan = StatusKesehatan::find($status[0]);
        if ($kesehatan->status < 1) {
            $this->emit('showAlertError', ['msg' => 'Anda tidak diizinkan untuk mengikuti MISA']);
            unset($this->status_kesehatan[$status[1]]);
        }
    }

    public function _reset()
    {
        $this->emit('closeModal');
        $this->pendaftaran_id = null;
        $this->status = null;
        $this->status_kesehatan = null;
        $this->jumlah_anggota = null;
        $this->username = [];
        $this->kuota = 0;
        // $this->status_kesehatan = [];
        $this->jadwal = null;
    }
}
