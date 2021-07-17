<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('client.home')}}">
                            <span><i class="fas fa-arrow-left mr-3 text-capitalize"></i>Riwayat Pendaftaran</span>
                        </a>
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-12 mx-auto cursor-pointer">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>Nama</td>
                            <td>Tanggal</td>
                            <td>Waktu</td>
                            <td>Aksi</td>
                        </tr>
                        @foreach ($pendaftarans as $pendaftaran)
                        <tr>
                            <td>{{$pendaftaran->user->name}}</td>
                            <td>{{$pendaftaran->jadwal->tanggal->isoFormat('dddd, D MMMM Y')}}</td>
                            <td>{{$pendaftaran->jadwal->waktu}}</td>
                            <td>
                                @if ($pendaftaran->user->id == auth()->user()->id)
                                @if ($pendaftaran->status == 2)
                                <button class="btn btn-danger btn-sm">Dibatalkan</button>
                                @else
                                <button class="btn btn-primary btn-sm"
                                    wire:click="getId('{{$pendaftaran->id}}')">Batal</button>
                                @endif
                                @else
                                <button class="btn btn-primary btn-sm" disabled>Batal</button>
                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>


    </div>

    {{-- Modal confirm --}}
    <div id="confirm-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog"
        aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" permission="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Konfirmasi Batal</h5>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin membatalkan pendaftaran.?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" wire:click='confirm' class="btn btn-danger btn-sm"><i
                            class="fa fa-check pr-2"></i>Ya, Batal</button>
                    <button class="btn btn-primary btn-sm" wire:click='_reset'><i class="fa fa-times pr-2"></i>Tutup</a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')

    <script>
        document.addEventListener('livewire:load', function(e) {
            
            

                window.livewire.on('showModal', (data) => {
                    $('#confirm-modal').modal('show')
                });
    
                window.livewire.on('closeModal', (data) => {
                    $('#confirm-modal').modal('hide')
                });
            })
    </script>
    @endpush
</div>