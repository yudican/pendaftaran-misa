<?php

namespace App\Http\Livewire;

use App\Models\DataAbsen;
use App\Models\DataUmat;
use App\Models\Jadwal;
use App\Models\User;
use Livewire\Component;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class Dashboard extends Component
{
    public function render()
    {
        $chart_options = [
            'chart_title' => 'Users by months',
            'report_type' => 'group_by_string',
            'model' => DataAbsen::class,
            'group_by_field' => 'jadwal',
            'group_by_period' => 'day',
            'chart_type' => 'line',
        ];
        $chart1 = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Users by names',
            'report_type' => 'group_by_string',
            'model' => DataAbsen::class,
            'group_by_field' => 'wilayah', // users.name
            'group_by_period' => 'day',
            'chart_type' => 'bar',
            'filter_days' => 30, // show only last 30 days
        ];
        $chart2 = new LaravelChart($chart_options);
        return view('livewire.dashboard', [
            'chart1' => $chart1,
            'chart2' => $chart2,
            'umat' => DataUmat::count(),
            'jadwal' => Jadwal::count(),
            'user' => User::count(),
        ]);
    }
}
