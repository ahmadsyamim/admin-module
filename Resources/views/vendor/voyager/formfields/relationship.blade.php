@if(isset($options->model) && isset($options->type))

    @if(class_exists($options->model))

        @php $relationshipField = $row->field; @endphp

        @if($options->type == 'belongsTo')

            @php
                $modelDataType = app('TCG\Voyager\Models\DataType');
                $queryDataType = $modelDataType::where('model_name', $options->model)->get()->first();
            @endphp

            @if(isset($view) && ($view == 'browse' || $view == 'read'))

                @php
                    $relationshipData = (isset($data)) ? $data : $dataTypeContent;
                    $model = app($options->model);
                    $query = $model::where($options->key,$relationshipData->{$options->column})->first();
                @endphp

                @if(isset($query))
                    <p>{{ $query->{$options->label} }}</p>
                @else
                    <p>{{ __('voyager::generic.no_results') }}</p>
                @endif

            @else

                @if(isset($options->barcode) && $options->barcode)
                @include('formfields.barcode', ['element' => $options->column ])
                @endif

                @if (request($options->column))
                <input type="hidden" name="{{ $options->column }}" value="{{ request($options->column) }}">
                @else
                <select class="ui fluid search selection dropdown search_{{ $options->column }}" name="{{ $options->column }}">
                     @php
                        $model = app($options->model);
                        $query = $model::where($options->key, old($options->column, $dataTypeContent->{$options->column}))->get();
                    @endphp
                    @if (request($row->field))
                        <option value="{{request($row->field)}}" selected="selected">{{request($row->field)}}</option>
                    @endif
                    @foreach($query as $relationshipData)
                        <option value="{{ $relationshipData->{$options->key} }}" @if(old($options->column, $dataTypeContent->{$options->column}) == $relationshipData->{$options->key}) selected="selected" @endif>{{ $relationshipData->{$options->label} }}</option>
                    @endforeach
                </select>

                @include('bread.partials.links')
                
                @push('javascript')
                <script>
                $(function () {
                    $('.ui.dropdown.search_{{ $options->column }}')
                        .dropdown({
                            minCharacters: 3,
                            clearable: false,
                            forceSelection: false,
                            allowReselection: false,
                            ignoreDiacritics: true,
                            showOnFocus: false,
                            selectOnKeydown: true,
                            apiSettings: {
                                cache:false,
                                url: "{{route('voyager.' . $dataType->slug.'.relation')}}?search={query}&type={{$row->field}}&method={{ !is_null($dataTypeContent->getKey()) ? 'edit' : 'add' }}&page=1&id=@if(!is_null($dataTypeContent->getKey())) {{$dataTypeContent->getKey()}} @endif"
                            },
                            fields: {
                                name: 'text',
                                text: 'text',
                                value: 'id',
                            },
                            onNoResults: function(searchValue) {
                                var dataType = "{{$dataType->slug??''}}";
                                var queryDataType = "{{$queryDataType->slug??''}}";
                                if (dataType !=  'purchases-items' && queryDataType != 'products') { return false; }
                                if (confirm("There is no item existed. Create new?")) {
                                    var return_key = 'barcode';
                                    if (isNaN(searchValue)) {
                                        return_key = 'name';
                                    }
                                    window.location.href = "{{ route('voyager.'.$queryDataType->slug.'.create', ['return' => true] ) }}&return_slug={{$dataType->slug}}&return_field={{$row->field}}&return_url={{url()->previous()}}&return_key="+return_key+"&"+return_key+"="+searchValue;
                                }
                            }
                        });
                        $('.ui.dropdown.search_{{ $options->column }}').dropdown('queryRemote', '{{old($options->column, $dataTypeContent->{$options->column} ?? request($row->field))}}', () => {
                            $('.ui.dropdown.search_{{ $options->column }}').dropdown('set selected', ['{{old($options->column, $dataTypeContent->{$options->column}  ?? request($row->field))}}' ]);
                        });
                });
                </script>
                @endpush 

                @endif

            @endif

        @elseif($options->type == 'hasOne')

            @php
                $relationshipData = (isset($data)) ? $data : $dataTypeContent;

                $model = app($options->model);
                $query = $model::where($options->column, '=', $relationshipData->{$options->key})->first();

            @endphp

            @if(isset($query))
                <p>{{ $query->{$options->label} }}</p>
            @else
                <p>{{ __('voyager::generic.no_results') }}</p>
            @endif

        @elseif($options->type == 'hasMany')

            @if(isset($view) && ($view == 'browse'))

                @php
                    $relationshipData = (isset($data)) ? $data : $dataTypeContent;
                    $model = app($options->model);

                    $selected_values = $model::where($options->column, '=', $relationshipData->{$options->key})->get()->map(function ($item, $key) use ($options) {
                        return $item->{$options->label};
                    })->all();
                @endphp

                @if($view == 'browse')
                    @php
                        $string_values = implode(", ", $selected_values);
                        if(mb_strlen($string_values) > 25){ $string_values = mb_substr($string_values, 0, 25) . '...'; }
                        
                        // WIP - quantity
                        if (isset($options->format->browse) && $options->format->browse == 'count') { 
                            $selected_values = $model::where($options->column, '=', $relationshipData->{$options->key})->get()->map(function ($item, $key) use ($options) {
                                $q = $item->quantity - $item->is_consumed;
                                return $q;
                            })->all();
                            $string_values = array_sum($selected_values);
                            if ($string_values < 1) {
                                $string_values = __('No Stock');
                            } 
                        }
                    @endphp
                    @if(empty($selected_values))
                        <p>{{ __('voyager::generic.no_results') }}</p>
                    @else
                        <p>{{ $string_values }}</p>
                    @endif
                @else
                    @if(empty($selected_values))
                        <p>{{ __('voyager::generic.no_results') }}</p>
                    @else
                        <ul>
                            @foreach($selected_values as $selected_value)
                                <li>{{ $selected_value }}</li>
                            @endforeach
                        </ul>
                    @endif
                @endif

            @else

                @php
                    $model = app($options->model);
                    $query = $model::where($options->column, '=', $dataTypeContent->{$options->key})->get();
                @endphp

                @php
                    $modelDataType = app('TCG\Voyager\Models\DataType');
                    $queryDataType = $modelDataType::where('model_name', $options->model)->get()->first();
                @endphp
                
                @if(isset($query))
                    @include('formfields.relationship.children', ['children_data' => $query, 'dataType' => $queryDataType ])
                @else
                    <p>{{ __('voyager::generic.no_results') }}</p>
                @endif

                @include('bread.partials.links')

            @endif

        @elseif($options->type == 'belongsToMany')

            @if(isset($view) && ($view == 'browse' || $view == 'read'))

                @php
                    $relationshipData = (isset($data)) ? $data : $dataTypeContent;

                    $selected_values = isset($relationshipData) ? $relationshipData->belongsToMany($options->model, $options->pivot_table, $options->foreign_pivot_key ?? null, $options->related_pivot_key ?? null, $options->parent_key ?? null, $options->key)->get()->map(function ($item, $key) use ($options) {
            			return $item->{$options->label};
            		})->all() : array();

                    $selected_data = isset($relationshipData) ? $relationshipData->belongsToMany($options->model, $options->pivot_table, $options->foreign_pivot_key ?? null, $options->related_pivot_key ?? null, $options->parent_key ?? null, $options->key)->get() : array();
                @endphp

                @if($view == 'browse')
                    @php
                        $string_values = implode(", ", $selected_values);
                        if(mb_strlen($string_values) > 25){ $string_values = mb_substr($string_values, 0, 25) . '...'; }
                    @endphp
                    @if(empty($selected_values))
                        <p>{{ __('voyager::generic.no_results') }}</p>
                    @else
                        <p>{{ $string_values }}</p>
                    @endif
                @else

                @php
                    $modelDataType = app('TCG\Voyager\Models\DataType');
                    $queryDataType = $modelDataType::where('model_name', $options->model)->get()->first();
                @endphp
               
                @if(isset($selected_data))
                    @include('formfields.relationship.children', ['children_data' => $selected_data, 'dataType' => $queryDataType ])
                @else
                <p>{{ __('voyager::generic.no_results') }}</p>
                @endif
                    @if(empty($selected_values))
                        <p>{{ __('voyager::generic.no_results') }}</p>
                    @else
                        <ul>
                            @foreach($selected_values as $selected_value)
                                <li>{{ $selected_value }}</li>
                            @endforeach
                        </ul>
                    @endif
                @endif

                @include('bread.partials.links')

            @else
                <select
                    class="form-control @if(isset($options->taggable) && $options->taggable === 'on') select2-taggable @else select2-ajax @endif"
                    name="{{ $relationshipField }}[]" multiple
                    data-get-items-route="{{route('voyager.' . $dataType->slug.'.relation')}}"
                    data-get-items-field="{{$row->field}}"
                    @if(!is_null($dataTypeContent->getKey())) data-id="{{$dataTypeContent->getKey()}}" @endif
                    data-method="{{ !is_null($dataTypeContent->getKey()) ? 'edit' : 'add' }}"
                    @if(isset($options->taggable) && $options->taggable === 'on')
                        data-route="{{ route('voyager.'.\Illuminate\Support\Str::slug($options->table).'.store') }}"
                        data-label="{{$options->label}}"
                        data-error-message="{{__('voyager::bread.error_tagging')}}"
                    @endif
                >

                        @php
                            $selected_values = isset($dataTypeContent) ? $dataTypeContent->belongsToMany($options->model, $options->pivot_table, $options->foreign_pivot_key ?? null, $options->related_pivot_key ?? null, $options->parent_key ?? null, $options->key)->get()->map(function ($item, $key) use ($options) {
                                return $item->{$options->key};
                            })->all() : array();
                            $relationshipOptions = app($options->model)->all();
                        $selected_values = old($relationshipField, $selected_values);
                        @endphp

                        @if(!$row->required)
                            <option value="">{{__('voyager::generic.none')}}</option>
                        @endif

                        @foreach($relationshipOptions as $relationshipOption)
                            <option value="{{ $relationshipOption->{$options->key} }}" @if(in_array($relationshipOption->{$options->key}, $selected_values)) selected="selected" @endif>{{ $relationshipOption->{$options->label} }}</option>
                        @endforeach

                </select>

            @endif

        @endif

    @else

        cannot make relationship because {{ $options->model }} does not exist.

    @endif

@endif
