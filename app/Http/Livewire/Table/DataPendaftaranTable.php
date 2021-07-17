<?php

namespace App\Http\Livewire\Table;

use App\Exports\DataPendaftaranExport;
use App\Models\HideableColumn;
use App\Models\Pendaftaran;
use Maatwebsite\Excel\Facades\Excel;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class DataPendaftaranTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable', 'setFilter'];
    public $hideable = 'select';
    public $table_name = 'data_pendaftaran';
    public $exportable = true;
    public $filters = [];
    public $hide = [];


    public function builder()
    {
        $jadwal_id = count($this->filters) > 0 ? $this->filters['jadwal_id'] : null;
        if ($jadwal_id) {
            return Pendaftaran::query()->where('jadwal_id', $jadwal_id)->where('status', '!=', 2);
        } else {
            return Pendaftaran::query()->where('status', '!=', 2);
        }
    }

    public function columns()
    {
        $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
        return [
            Column::name('user.name')->label('Nama')->searchable(),
            Column::name('user.dataUmat.linkungan')->label('Lingkungan')->searchable(),
            Column::name('user.dataUmat.wilayah')->label('Wilayah')->searchable(),
            Column::name('user.dataUmat.telepon')->label('Telepon')->searchable(),
            Column::callback(['id', 'status', 'jadwal.tanggal', 'jadwal.waktu'], function ($id, $status, $tanggal, $waktu) {
                $tgl = date('Y-m-d', strtotime($tanggal)) . ' ' . $waktu;
                return view('livewire.components.button-status', [
                    'id' => $id,
                    'status' => $status,
                    'jadwal' => strtotime(date('Y-m-d H:i:s')) >= strtotime($tgl)
                ]);
            })->label(__('Status')),
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

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }

    public function setFilter($data)
    {
        $this->filters = $data;
    }

    public function export()
    {
        $jadwal_id = count($this->filters) > 0 ? $this->filters['jadwal_id'] : null;
        return Excel::download(new DataPendaftaranExport($jadwal_id), 'data-pendaftaran.xlsx');
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
