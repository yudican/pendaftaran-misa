<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\Pendaftaran;
use App\Models\User;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class CatatanPembatalanTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable', 'setFilter'];
    public $hideable = 'select';
    public $table_name = 'catatan_pembatalan';
    public $filters = [];
    public $hide = [];


    public function builder()
    {
        if (count($this->filters)) {
            $tanggal_mulai = $this->filters['tanggal_mulai'];
            $tanggal_selesai = $this->filters['tanggal_selesai'];
            if ($tanggal_mulai && $tanggal_selesai) {
                return Pendaftaran::query()->whereHas('jadwal', function ($query) use ($tanggal_mulai, $tanggal_selesai) {
                    return $query->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai]);
                })->where('status', '2');
            }
        }
        return Pendaftaran::query()->where('status', '2');
    }

    public function columns()
    {
        $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
        return [
            Column::name('user.name')->label('Nama')->searchable(),
            Column::name('user.dataUmat.linkungan')->label('Lingkungan')->searchable(),
            Column::name('user.dataUmat.wilayah')->label('Wilayah')->searchable(),
            Column::name('jadwal.tanggal')->label('Jadwal'),
            Column::name('user.dataUmat.telepon')->label('Telepon'),
            Column::name('alasan')->label('Alasan'),
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
