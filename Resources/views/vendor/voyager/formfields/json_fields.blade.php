{{-- <textarea
    @if($row->required == 1) required @endif class="form-control" name="{{ $row->field }}" rows="{{ $options->display->rows ?? 5 }}">{{ old($row->field, $dataTypeContent->{$row->field} ?? $options->default ?? '') }}</textarea> --}}

</div>
@foreach (Theme::getSettings() as $name => $value)
<div class="form-group  col-md-12 ">
    @if (is_array($value))
    <fieldset class="border p-2">
   <legend  class="float-none w-auto p-2"><label class="control-label" for="theme_setting[{{$name}}]">{{ ucwords(str_replace('-',' ',$name)) }}</label></legend>

    @foreach ($value as $n => $v)
        <div>
            <label class="control-label" for="theme_setting[{{$n}}]">{{ ucwords(str_replace('-',' ',$n)) }}</label>
        </div>
        <input type="text" class="form-control" name="theme_setting[{{$n}}]" value="{{ $v }}">
    @endforeach
    </fieldset>
    @else
    <div>
        <label class="control-label" for="theme_setting[{{$name}}]">{{ ucwords(str_replace('-',' ',$name)) }}</label>
    </div>
    <input type="text" class="form-control" name="theme_setting[{{$name}}]" value="{{ $value }}">
    @endif
</div>
@endforeach

<div>