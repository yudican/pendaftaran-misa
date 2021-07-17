<?php

namespace App\Http\Livewire\Table;

use App\Exports\DataAbsenExport;
use App\Models\HideableColumn;
use App\Models\DataAbsen;
use Maatwebsite\Excel\Facades\Excel;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class DataAbsenTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable', 'setFilter'];
    public $hideable = 'select';
    public $table_name = 'absen_umat';
    public $exportable = true;
    public $filters = [];
    public $hide = [];


    public function builder()
    {
        $jadwal_id = count($this->filters) > 0 ? $this->filters['jadwal_id'] : null;
        if ($jadwal_id) {
            return DataAbsen::with('pendaftaran', 'user')->whereHas('pendaftaran', function ($query) use ($jadwal_id) {
                return $query->where('jadwal_id', $jadwal_id);
            });
        } else {
            return DataAbsen::with('pendaftaran', 'user');
        }
    }

    public function columns()
    {
        $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
        return [
            Column::name('user.name')->label('Nama')->searchable(),
            Column::name('pendaftaran.user.dataUmat.linkungan')->label('Lingkungan')->searchable(),
            Column::name('pendaftaran.user.dataUmat.wilayah')->label('Wilayah')->searchable(),
            Column::name('pendaftaran.jadwal.tanggal')->label('Jadwal')->searchable(),

            // Column::callback(['id'], function ($id) {
            //     return view('livewire.components.action-button', [
            //         'id' => $id,
            //         'segment' => request()->segment(1)
            //     ]);
            // })->label(__('Aksi')),
        ];
    }

    public function getDataById($id)
    {
        $this->emit('getDataById', $id);
    }

    public function getId($id)
    {
        $this->emit('getId', $id);
    }

    public function export()
    {
        $jadwal_id = count($this->filters) > 0 ? $this->filters['jadwal_id'] : null;
        return Excel::download(new DataAbsenExport($jadwal_id), 'data-absen.xlsx');
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
