<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3 text-capitalize"></i>Data Pendaftaran</span>
                        </a>
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <x-select name="jadwal_id" component="filterData" change="true" label="Pilih Jadwal">
                        <option value="">Pilih Jadwal</option>
                        @foreach ($jadwals as $jadwal)
                        <option value="{{$jadwal->id}}">{{$jadwal->tanggal->isoFormat('dddd, D MMMM Y')}} -
                            {{$jadwal->waktu}}</option>
                        @endforeach
                    </x-select>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <livewire:table.data-pendaftaran-table />
        </div>

    </div>
    @push('scripts')


    <script>
        document.addEventListener('livewire:load', function(e) {
            window.livewire.on('showModal', (data) => {
                $('#form-modal').modal('show')
            });

            window.livewire.on('closeModal', (data) => {
                $('#confirm-modal').modal('hide')
                $('#form-modal').modal('hide')
            });
        })
    </script>
    @endpush
</div>