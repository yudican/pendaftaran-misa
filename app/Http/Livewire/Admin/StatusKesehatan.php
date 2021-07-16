<?php

namespace App\Http\Livewire\Admin;

use App\Models\StatusKesehatan as ModelsStatusKesehatan;
use Livewire\Component;


class StatusKesehatan extends Component
{
    
    public $status_kesehatan_id;
    public $status_kesehatan;
    
   

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.admin.status-kesehatan', [
            'items' => ModelsStatusKesehatan::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        
        $data = ['status_kesehatan'  => $this->status_kesehatan];

        ModelsStatusKesehatan::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = ['status_kesehatan'  => $this->status_kesehatan];
        $row = ModelsStatusKesehatan::find($this->status_kesehatan_id);

        

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsStatusKesehatan::find($this->status_kesehatan_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'status_kesehatan'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataById($status_kesehatan_id)
    {
        $status_kesehatan = ModelsStatusKesehatan::find($status_kesehatan_id);
        $this->status_kesehatan_id = $status_kesehatan->id;
        $this->status_kesehatan = $status_kesehatan->status_kesehatan;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($status_kesehatan_id)
    {
        $status_kesehatan = ModelsStatusKesehatan::find($status_kesehatan_id);
        $this->status_kesehatan_id = $status_kesehatan->id;
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
        $this->status_kesehatan_id = null;
        $this->status_kesehatan = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
