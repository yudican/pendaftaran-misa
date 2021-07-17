@if ($jadwal)
@if ($status == 1)
<button class="btn btn-success btn-sm" id="btn-hadir-{{$id}}">Hadir</button>
@else
<button class="btn btn-danger btn-sm" id="btn-tidak-hadir-{{$id}}">Tidak Hadir</button>
@endif
@else
<button class="btn btn-primary btn-sm" id="btn-mulai-{{$id}}">Belum Absen</button>
@endif