<div class="page-inner">
    <div class="row">
        <div class="col-md-12 text-center mb-4">
            <h1>Selamat datang</h1>
        </div>
        @if (auth()->user()->hasTeamPermission($curteam, 'pendaftaran:read'))
        <div class="col-lg-3 col-md-3 col-sm-6 col-12 mx-auto cursor-pointer" wire:click="selectMenu('pendaftaran')">
            <div class="card card-stats card-primary card-round">
                <div class="card-body">
                    <div class="numbers text-center">
                        <h4 class="card-title mb-0">Pendaftaran Misa</h4>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if (auth()->user()->hasTeamPermission($curteam, 'cek-pendaftaran:read'))
        <div class="col-lg-3 col-md-3 col-sm-6 col-12 mx-auto cursor-pointer"
            wire:click="selectMenu('cek.pendaftaran')">
            <div class="card card-stats card-primary card-round">
                <div class="card-body">
                    <div class="numbers text-center">
                        <h4 class="card-title mb-0">Cek Pendaftaran</h4>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if (auth()->user()->hasTeamPermission($curteam, 'riwayat-pendaftaran:read'))
        <div class="col-lg-3 col-md-3 col-sm-6 col-12 mx-auto cursor-pointer"
            wire:click="selectMenu('riwayat.pendaftaran')">
            <div class="card card-stats card-primary card-round">
                <div class="card-body">
                    <div class="numbers text-center">
                        <h4 class="card-title mb-0">Riwayat Pendaftaran</h4>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if (auth()->user()->hasTeamPermission($curteam, 'barcode:read'))
        <div class="col-md-6 mx-auto" wire:ignore>
            <div id="reader" width="600px"></div>
        </div>
        @endif
    </div>

    @push('scripts')
    <script src="https://blog.minhazav.dev/assets/research/html5qrcode/html5-qrcode.min.js"></script>
    <script>
        document.addEventListener('livewire:load', function(e) {
            var status = true
            function onScanSuccess(decodedText, decodedResult) {
            // handle the scanned code as you like, for example:
                status && @this.call(`cekUmat`,decodedText)
                status = false
            }
            
            function onScanFailure(error) {
            status = true
            }
            
            let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 50, qrbox: 250 }, /* verbose= */ false);
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);

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