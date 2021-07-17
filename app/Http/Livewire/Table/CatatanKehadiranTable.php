<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\DataAbsen;
use App\Models\Pendaftaran;
use App\Models\User;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class CatatanKehadiranTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable', 'setFilter'];
    public $hideable = 'select';
    public $table_name = 'catatan_kehadiran';
    public $filters = [];
    public $hide = [];


    public function builder()
    {
        if (count($this->filters) > 0) {
            $tanggal_mulai = $this->filters['tanggal_mulai'];
            $tanggal_selesai = $this->filters['tanggal_selesai'];
            return Pendaftaran::whereHas('jadwal', function ($query) use ($tanggal_mulai, $tanggal_selesai) {
                return $query->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai]);
            })->whereDoesntHave('dataAbsens', function ($q) {
                return $q->has('pendaftaran', '>=', 3);
            })->where('status', '0');
        }
        return Pendaftaran::whereHas('jadwal', function ($query) {
            return $query->whereDate('tanggal', '<=', date('Y-m-d'));
        })->whereDoesntHave('dataAbsens', function ($q) {
            return $q->has('pendaftaran', '>=', 3);
        })->where('status', '0');
    }

    public function columns()
    {
        $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
        return [
            Column::name('user.name')->label('Nama')->searchable(),
            Column::name('user.dataUmat.linkungan')->label('Lingkungan')->searchable(),
            Column::name('user.dataUmat.wilayah')->label('Wilayah')->searchable(),
            Column::name('jadwal.tanggal')->label('Jadwal')->searchable(),
            Column::name('user.dataUmat.telepon')->label('Telepon')->searchable(),
            // Column::callback(['id'], function ($id) {
            //     return view('livewire.components.action-button', [
            //         'id' => $id,
            //         'segment' => request()->segment(1)
            //     ]);
            // })->label(__('Aksi')),

            // Column::callback(['id'], function ($id) {
            //     return view('livewire.components.action-button', [
            //         'id' => $id,
            //         'segment' => request()->segment(1)
            //     ]);
            // })->label(__('Aksi')),
        ];
    }

    public function getUserProperty()
    {
        $user = User::all();

        return $user;
    }

    public function getDataById($id)
    {
        $this->emit('getDataById', $id);
    }

    public function getId($id)
    {
        $this->emit('getId', $id);
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }

    public function setFilter($data)
    {
        $this->filters = $data;
    }

    public function toggle($index)
    {
        if ($this->sort == $index) {
            $this->initialiseSort();
        }

        $column = HideableColumn::where([
            'table_name' => $this->table_name,
            'column_name' => $this->columns[$index]['name'],
            'index' => $index,
            'user_id' => auth()->user()->id
        ])->first();

        if (!$this->columns[$index]['hidden']) {
            unset($this->activeSelectFilters[$index]);
        }

        $this->columns[$index]['hidden'] = !$this->columns[$index]['hidden'];

        if (!$column) {
            HideableColumn::updateOrCreate([
                'table_name' => $this->table_name,
                'column_name' => $this->columns[$index]['name'],
                'index' => $index,
                'user_id' => auth()->user()->id
            ]);
        } else {
            $column->delete();
        }
    }
}
