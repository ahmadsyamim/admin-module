<div class="right floated thirteen wide computer sixteen wide phone column apolloApp" id="content">
    <div class="ui container centered grid">
        <div class="row stretched">
            <div class="fifteen wide computer sixteen wide phone centered column">
                <h2><i class="home icon"></i> DASHBOARD</h2>
                <div class="ui divider"></div>
                <div class="ui grid">
                    <!-- BEGIN STATISTIC ITEM -->
                    <!-- Begin Page Views -->
                    <div class="four wide computer sixteen wide phone centered column">
                        @php
                        $dimmerGroups = Voyager::dimmers();
                        @endphp
                        @if (count($dimmerGroups))
                        @foreach($dimmerGroups as $dimmerGroup)
                        @php
                        $count = $dimmerGroup->count();
                        $classes = [
                        'col-xs-12',
                        'col-sm-'.($count >= 2 ? '6' : '12'),
                        'col-md-'.($count >= 3 ? '4' : ($count >= 2 ? '6' : '12')),
                        ];
                        $class = implode(' ', $classes);
                        $prefix = "<div class='{$class}'>";
                            $prefix = '';
                            $surfix = '';
                            @endphp
                            @if ($dimmerGroup->any())
                            {!! $prefix.$dimmerGroup->setSeparator($surfix.$prefix)->display().$surfix !!}
                            @endif
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>