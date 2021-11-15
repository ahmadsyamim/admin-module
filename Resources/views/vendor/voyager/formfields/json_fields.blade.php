{{-- <textarea
    @if($row->required == 1) required @endif class="form-control" name="{{ $row->field }}" rows="{{ $options->display->rows ?? 5 }}">{{ old($row->field, $dataTypeContent->{$row->field} ?? $options->default ?? '') }}</textarea> --}}

</div>
@foreach (Theme::getSettings() as $name => $value)
<div class="form-group  col-md-12 ">
    <label class="control-label" for="theme_setting[{{$name}}]">{{ $name }}</label>
    <br>
    @if (is_array($value))
    @foreach ($value as $n => $v)
        <label class="control-label" for="theme_setting[{{$n}}]">{{ $n }}</label>
        <br>
        <input type="text" class="form-control" name="theme_setting[{{$n}}]" value="{{ $v }}">
    @endforeach
    @else
    <input type="text" class="form-control" name="theme_setting[{{$name}}]" value="{{ $value }}">
    @endif
</div>
@endforeach

<div>