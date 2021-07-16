<?php

namespace App\Http\Livewire\Admin;

use App\Models\DataAbsen as ModelsDataAbsen;
use App\Models\Jadwal;
use Livewire\Component;


class DataAbsen extends Component
{

    public $absen_umat_id;
    public $pendaftaran_id;
    public $jadwal_id;



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.admin.absen-umat', [
            'items' => ModelsDataAbsen::all(),
            'jadwals' => Jadwal::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = ['pendaftaran_id'  => $this->pendaftaran_id];

        ModelsDataAbsen::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = ['pendaftaran_id'  => $this->pendaftaran_id];
        $row = ModelsDataAbsen::find($this->absen_umat_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsDataAbsen::find($this->absen_umat_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'pendaftaran_id'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function filterData($value)
    {
        $this->emit('setFilter', ['jadwal_id' => $value]);
    }

    public function getDataById($absen_umat_id)
    {
        $absen_umat = ModelsDataAbsen::find($absen_umat_id);
        $this->absen_umat_id = $absen_umat->id;
        $this->pendaftaran_id = $absen_umat->pendaftaran_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($absen_umat_id)
    {
        $absen_umat = ModelsDataAbsen::find($absen_umat_id);
        $this->absen_umat_id = $absen_umat->id;
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
        $this->emit('closeModal');
        $this->emit('refreshTable');
        $this->absen_umat_id = null;
        $this->pendaftaran_id = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
