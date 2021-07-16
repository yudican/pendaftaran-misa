<?php

namespace App\Http\Livewire\Client;

use App\Models\Jadwal;
use App\Models\Pendaftaran as ModelsPendaftaran;
use App\Models\Role;
use App\Models\StatusKesehatan;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;


class Pendaftaran extends Component
{

    public $pendaftaran_id;
    public $status;
    public $jadwal_id;
    public $jumlah_anggota;
    public $tab = 1;
    public $nama = [];
    public $tanggal_lahir = [];
    public $status_kesehatan = [];
    public $jadwal;



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.admin.pendaftaran', [
            'items' => ModelsPendaftaran::all(),
            'jadwals' => Jadwal::whereDate('tanggal', '>=', date('Y-m-d'))->get(),
            'kesehatans' => StatusKesehatan::all(),
            'pendaftarans' => ModelsPendaftaran::where(['parent_id'  => auth()->user()->dataUmat->id])->get()
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
            $validate = $this->validate([
                'nama.*' => 'required',
                'tanggal_lahir.*' => 'required',
                'status_kesehatan.*' => 'required',
            ]);

            $jadwal = Jadwal::find($this->jadwal_id);
            $this->jadwal = $jadwal->tanggal->isoFormat('dddd, D MMMM Y');
        }


        $this->tab = $tab;
    }

    public function confirm()
    {
        $validate = $this->validate([
            'nama.*' => 'required',
            'tanggal_lahir.*' => 'required',
            'status_kesehatan.*' => 'required',
        ]);

        foreach ($this->nama as $key => $value) {
            $namadepan = explode(' ', $this->nama[$key]) ? explode(' ', $this->nama[$key])[0] : $this->nama[$key];
            $password = date('dmY', strtotime($this->tanggal_lahir[$key]));
            $user = User::create([
                'name'  => $this->nama[$key],
                'username'  => strtolower($namadepan) . $password,
                'password'  => Hash::make($password),
                'parent_id'  => auth()->user()->id,
            ]);

            $team = Team::find(1);
            $team->users()->attach($user, ['role' => 'keluarga']);

            $role = Role::where('role_type', 'keluarga')->first();
            $user->roles()->attach($role);
            ModelsPendaftaran::create(
                [
                    'jadwal_id' => $this->jadwal_id,
                    'user_id' => $user->id,
                    'status_kesehatan_id' => $this->status_kesehatan[$key],
                    'parent_id'  => auth()->user()->dataUmat->id,
                ]
            );
        }

        $this->tab = 4;
        $this->_reset();
        $this->emit('showAlert', ['msg' => 'Pendaftaran Berhasil']);
    }

    public function _reset()
    {
        $this->emit('closeModal');
        $this->pendaftaran_id = null;
        $this->status = null;
        $this->status_kesehatan = null;
        $this->jumlah_anggota = null;
        $this->jadwal_id = null;
        $this->nama = [];
        $this->tanggal_lahir = [];
        $this->status_kesehatan = [];
        $this->jadwal = null;
    }
}
