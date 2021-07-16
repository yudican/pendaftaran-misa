<?php

namespace App\Http\Livewire\Admin;

use App\Models\Jadwal as ModelsJadwal;
use Livewire\Component;


class Jadwal extends Component
{

    public $jadwal_id;
    public $tanggal;
    public $waktu;
    public $kuota_tersedia;



    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.admin.jadwal', [
            'items' => ModelsJadwal::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'tanggal'  => $this->tanggal,
            'waktu'  => $this->waktu,
            'kuota_tersedia'  => $this->kuota_tersedia
        ];

        ModelsJadwal::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'tanggal'  => $this->tanggal,
            'waktu'  => $this->waktu,
            'kuota_tersedia'  => $this->kuota_tersedia
        ];
        $row = ModelsJadwal::find($this->jadwal_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsJadwal::find($this->jadwal_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'tanggal'  => 'required',
            'waktu'  => 'required',
            'kuota_tersedia'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataById($jadwal_id)
    {
        $jadwal = ModelsJadwal::find($jadwal_id);
        $this->jadwal_id = $jadwal->id;
        $this->tanggal = $jadwal->tanggal;
        $this->waktu = $jadwal->waktu;
        $this->kuota_tersedia = $jadwal->kuota_tersedia;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($jadwal_id)
    {
        $jadwal = ModelsJadwal::find($jadwal_id);
        $this->jadwal_id = $jadwal->id;
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
        $this->jadwal_id = null;
        $this->tanggal = null;
        $this->waktu = null;
        $this->kuota_tersedia = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
