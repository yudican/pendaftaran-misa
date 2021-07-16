<div class="page-inner">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Jumlah Umat</p>
                                <h4 class="card-title">{{$umat}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-money-check-alt"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Jumlah Jadwal</p>
                                <h4 class="card-title">{{$jadwal}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-wallet"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Jumlah User</p>
                                <h4 class="card-title">{{$user}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Perbandingan Kehadiran</div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        {!! $chart1->renderHtml() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Rata-rata Umat Setiap Minggu</div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        {!! $chart2->renderHtml() !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-md-12">
            <livewire:table.jadwal-table />
        </div> --}}
    </div>
    @push('scripts')
    {!! $chart1->renderChartJsLibrary() !!}
    {!! $chart1->renderJs() !!}
    {!! $chart2->renderJs() !!}
    @endpush
</div