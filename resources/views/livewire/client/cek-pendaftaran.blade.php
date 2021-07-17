<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('client.home')}}">
                            <span><i class="fas fa-arrow-left mr-3 text-capitalize"></i>Cek Pendaftaran</span>
                        </a>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-center mb-4">
            <h1>Daftar Umat Misa Offline</h1>
        </div>

        <div class="col-md-12 mx-auto cursor-pointer">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <x-select name="jadwal_id" change="true" label="Pilih Jadwal">
                        <option value="">Pilih Jadwal</option>
                        @foreach ($jadwals as $jadwal)
                        <option value="{{$jadwal->id}}">{{$jadwal->tanggal->isoFormat('dddd, D MMMM Y')}} -
                            {{$jadwal->waktu}}</option>
                        @endforeach
                    </x-select>
                    <table class="table table-bordered">
                        <tr>
                            <td>Nama</td>
                            <td>Lingkungan</td>
                            {{-- <td>Barcode</td> --}}
                        </tr>
                        @foreach ($pendaftarans as $pendaftaran)
                        <tr>
                            <td>{{$pendaftaran->user->name}}</td>
                            <td class="p-2">{{$pendaftaran->user->dataUmat->linkungan}}</td>
                            {{-- <td class="m-2">{!!QrCode::size(200)->generate($pendaftaran->id)!!}
                            </td> --}}
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
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