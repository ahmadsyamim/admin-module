@php 
$except = $except ?? array();
$actionParams = $actionParams ?? array('type'=>false, 'id'=>false);
if ($data && $data->getKey()) {
    $actionParams['id'] = $data->getKey();
}
@endphp
@if($data && $action->getTitle($actionParams) && !in_array($action->getPolicy(), $except) && !method_exists($action, 'massAction') && (method_exists($action, 'isSingle') && $action->isSingle() || !method_exists($action, 'isSingle')))
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
@elseif ($action->getTitle($actionParams) && isset($dataType) && method_exists($action, 'massAction'))
    @if (!$action->isBulk() && (isset($actionParams['type']) && !$actionParams['type']))

    @else 
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
@endif
