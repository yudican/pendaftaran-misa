<?php

namespace App\Http\Livewire\Admin;

use App\Models\DataUmat as ModelsDataUmat;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;


class DataUmat extends Component
{

    public $data_umat_id;
    public $nama_lengkap;
    public $tanggal_lahir;
    public $alamat;
    public $linkungan;
    public $wilayah;
    public $telepon;



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.admin.data-umat', [
            'items' => ModelsDataUmat::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'nama_lengkap'  => $this->nama_lengkap,
            'tanggal_lahir'  => $this->tanggal_lahir,
            'alamat'  => $this->alamat,
            'linkungan'  => $this->linkungan,
            'wilayah'  => $this->wilayah,
            'telepon'  => $this->telepon
        ];



        $namadepan = explode(' ', $this->nama_lengkap) ? explode(' ', $this->nama_lengkap)[0] : $this->nama_lengkap;
        $password = date('dmY', strtotime($this->tanggal_lahir));
        $user = User::create([
            'name'  => $this->nama_lengkap,
            'username'  => strtolower($namadepan) . $password,
            'password'  => Hash::make($password),
        ]);
        $data['user_id'] = $user->id;
        $team = Team::find(1);
        $team->users()->attach($user, ['role' => 'anggota']);

        $role = Role::where('role_type', 'anggota')->first();
        $user->roles()->attach($role);
        $data_umat = ModelsDataUmat::create($data);
        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'nama_lengkap'  => $this->nama_lengkap,
            'tanggal_lahir'  => $this->tanggal_lahir,
            'alamat'  => $this->alamat,
            'linkungan'  => $this->linkungan,
            'wilayah'  => $this->wilayah,
            'telepon'  => $this->telepon
        ];
        $row = ModelsDataUmat::find($this->data_umat_id);


        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsDataUmat::find($this->data_umat_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'nama_lengkap'  => 'required',
            'tanggal_lahir'  => 'required',
            'alamat'  => 'required',
            'linkungan'  => 'required',
            'wilayah'  => 'required',
            'telepon'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataById($data_umat_id)
    {
        $data_umat = ModelsDataUmat::find($data_umat_id);
        $this->data_umat_id = $data_umat->id;
        $this->nama_lengkap = $data_umat->nama_lengkap;
        $this->tanggal_lahir = $data_umat->tanggal_lahir;
        $this->alamat = $data_umat->alamat;
        $this->linkungan = $data_umat->linkungan;
        $this->wilayah = $data_umat->wilayah;
        $this->telepon = $data_umat->telepon;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($data_umat_id)
    {
        $data_umat = ModelsDataUmat::find($data_umat_id);
        $this->data_umat_id = $data_umat->id;
    }

    public function toggleForm($form)
    {
        $this->form_active = $form;
        $this->emit('loadForm');
    }

    public function showModal()
    {
        $this->emit('showModal');
    }

    public function _reset()
    {
        $this->emit('refreshTable');
        $this->emit('closeModal');
        $this->data_umat_id = null;
        $this->nama_lengkap = null;
        $this->tanggal_lahir = null;
        $this->alamat = null;
        $this->linkungan = null;
        $this->wilayah = null;
        $this->telepon = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
