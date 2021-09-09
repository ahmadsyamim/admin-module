<div class="ui fluid {{ isset($options->right) ? 'right' : ''  }} labeled input">
    @isset($options->left)
    <label for="{{ $row->field }}" class="ui label">{{$options->left}}</label>
    @endisset
    <input type="number" name="{{ $row->field }}" type="number" @if($row->required == 1) required @endif
    @if(isset($options->min)) min="{{ $options->min }}" @endif
    @if(isset($options->max)) max="{{ $options->max }}" @endif
    step="{{ $options->step ?? 'any' }}"
    placeholder="{{ old($row->field, $options->placeholder ?? $row->getTranslatedAttribute('display_name')) }}"
    value="{{ old($row->field, $dataTypeContent->{$row->field} ?? $options->default ?? '') }}">
    @isset($options->right)
    <div class="ui basic label">{{$options->right}}</div>
    @endisset
</div>