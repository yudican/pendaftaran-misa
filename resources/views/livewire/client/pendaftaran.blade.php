<div class="page-inner">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title text-capitalize">
            <a href="{{route('client.home')}}">
              <span><i class="fas fa-arrow-left mr-3 text-capitalize"></i>Pendaftaran Misa Gereja</span>
            </a>
          </h4>
        </div>
      </div>
    </div>
    @switch($tab)
    @case(1)
    <div class="col-md-12">
      <div class="alert alert-info" role="alert">
        Sebelum mengikuti misa, seluruh umat diwajibkan untuk mengisi segala bentuk informasi yang dibutuhkan
        secara JUJUR dan AKURAT
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="header-title">Pilih Jadwal Misa</h3>
        </div>
        <div class="card-body">
          <x-select name="jadwal_id" change="true"
            label="Jadwal Misa (Bila tidak terdapat pilihan maka kuota telah habis)">
            <option value="">Pilih Jadwal</option>
            @foreach ($jadwals as $jadwal)
            @if ($jadwal->pendaftarans->count() >= $jadwal->kuota_tersedia)
            <option value="" disabled>{{$jadwal->tanggal->isoFormat('dddd, D MMMM Y')}} -
              {{$jadwal->waktu}}</option>
            @else
            <option value="{{$jadwal->id}}">{{$jadwal->tanggal->isoFormat('dddd, D MMMM Y')}} -
              {{$jadwal->waktu}}</option>
            @endif

            @endforeach
          </x-select>
          <x-select name="jumlah_anggota" label="Jumlah Anggota">
            <option value="">Pilih Jumlah</option>
            @if ($kuota > 10)
            @for ($in = 0; $in < 10; $in++) <option value="{{$in+1}}">{{$in+1}} Orang</option>
              @endfor
              @else
              @for ($i = 0; $i < $kuota; $i++) <option value="{{$i+1}}">{{$i+1}} Orang</option>
                @endfor
                @endif


          </x-select>

          <div class="form-group">
            <button class="btn btn-primary btn-sm" wire:click="getForm(2,true)">Lanjut</button>
          </div>
        </div>
      </div>
    </div>
    @break
    @case(2)
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="header-title">Umat</h3>
        </div>
        <div class="card-body">
          @for ($i = 0; $i
          < $jumlah_anggota; $i++) <div class="card">
            <x-text-field type="text" name="username.{{$i}}" label="Username" />
            <x-select change="true" component="cekStatus" name="status_kesehatan.{{$i}}" label="Status Kesehatan">
              <option value="">Pilih Status Kesehatan</option>
              @foreach ($kesehatans as $kesehatan)
              <option value="{{$kesehatan->id}}.{{$i}}">{{$kesehatan->status_kesehatan}}</option>
              @endforeach
            </x-select>
        </div>

        <div class="sparator"></div>
        @endfor
        <div class="form-group">
          <button class="btn btn-primary btn-sm" wire:click.prevent="getForm(3,true)">Lanjut</button>
        </div>
      </div>
    </div>
    @break
    @case(3)
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="header-title">Data Umat</h3>
        </div>
        <div class="card-body">
          <ul class="list-group list-group-bordered">
            <li class="list-group-item d-flex justify-content-between align-items-center">
              Jadwal Misa
              <span>{{$jadwal}}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              Jumlah Orang
              <span>{{$jumlah_anggota}}</span>
            </li>
            @foreach ($data_umat as $key => $item)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              Nama Umat {{$key+1}}
              <span>{{$item->nama_lengkap}}</span>
            </li>
            @endforeach

            {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
              Lingkungan
              <span>{{auth()->user()->dataUmat->linkungan}}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              Wilayah
              <span>{{auth()->user()->dataUmat->wilayah}}</span>
            </li> --}}
          </ul>
          <div class="form-group">
            <button class="btn btn-primary btn-sm" wire:click.prevent="confirm">Konfirmasi Daftar</button>
          </div>
        </div>

      </div>
    </div>
    @break
    @case(4)
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="header-title">Data Umat</h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <td>Nama</td>
                <td>Kode Qr</td>
              </tr>
            </thead>
            <tbody>
              @foreach ($pendaftarans as $pendaftaran)
              <tr>
                <td>{{$pendaftaran->user->name}}</td>
                <td class="p-2">{!! QrCode::size(70)->generate($pendaftaran->id); !!}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="form-group">
            <a href="{{route('cetak_barcode', ['jadwal_id' => $jadwal_id])}}" target="_blank"
              class="btn btn-primary btn-sm">Cetak</a>
            <a href="{{route('client.home')}}" class="btn btn-success btn-sm">Kembali
              Halaman Utama</a>
          </div>
        </div>

      </div>
    </div>
    @break
    @default

    @endswitch
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