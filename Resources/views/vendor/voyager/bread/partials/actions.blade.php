@php 
$except = $except ?? array();
$actionParams = $actionParams ?? array('type'=>false);
@endphp
@if($data && !in_array($action->getPolicy(), $except) && !method_exists($action, 'massAction'))
    @php
        // need to recreate object because policy might depend on record data
        $class = get_class($action);
        $action = new $class($dataType, $data);
    @endphp
    @can ($action->getPolicy(), $data)
        <a href="{{ (isset($actionParams) && is_array($actionParams) && $action->getRoute($dataType->name) != 'javascript:;' ? url($action->getRoute($dataType->name)).'?'.Arr::query($actionParams) : $action->getRoute($dataType->name)) }}" title="{{ $action->getTitle($actionParams) }}" {!! $action->convertAttributesToHtml($actionParams) !!}>
            <i class="{{ $action->getIcon() }}"></i> <span class="hidden-xs hidden-sm">{{ $action->getTitle($actionParams) }}</span>
        </a>
    @endcan
@elseif (isset($dataType) && method_exists($action, 'massAction'))
    <form method="post" action="{{ route('voyager.'.$dataType->slug.'.action') }}" style="display:inline">
        {{ csrf_field() }}
        <button type="submit" {!! $action->convertAttributesToHtml($actionParams) !!}><i class="{{ $action->getIcon() }}"></i>  {{ $action->getTitle($actionParams) }}</button>
        <input type="hidden" name="action" value="{{ get_class($action) }}">
        @if (isset($actionParams['type']) && ($actionParams['type'] == 'single' || $actionParams['type'] == 'widget'))
        <input type="hidden" name="ids" value="{{ $data->getKey() }}" class="">
        @else
        <input type="hidden" name="ids" value="" class="selected_ids">
        @endif
    </form>
@endif
