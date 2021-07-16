<div class="form-group {{$errors->has($name) ? 'has-error has-feedback' : '' }}">
  <label for="{{$name}}" class="placeholder" style="overflow-x:wrap"><b>{{$label}}</b></label>

  <select name="{{$name}}" wire:model="{{$name}}" @if (isset($change)=='true' )
    wire:change="cekPendaftaran($event.target.value)" @endif class="form-control">
    {{$slot}}
  </select>
  <small id="helpId" class="text-danger">{{ $errors->has($name) ? $errors->first($name) : '' }}</small>
</div>