<div class="page-inner">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3 text-capitalize"></i>Data Absen</span>
                        </a>
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <x-text-field type="date" name="tanggal_mulai" label="Tanggal Awal" />

                        </div>
                        <div class="col-md-4">
                            <x-text-field type="date" name="tanggal_selesai" min="{{$tanggal_mulai}}"
                                label="Tanggal Akhir" />
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <button class="btn btn-primary btn-sm" wire:click="setFilter">Filter</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <livewire:table.catatan-kehadiran-table />
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