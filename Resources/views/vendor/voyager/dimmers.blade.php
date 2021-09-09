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
                        <div class="ui raised segment">
                            <div class="content">
                                <div class="ui centered grid">
                                    <div class="row">
										<div class="ui statistic">
											<div class="value">
												<i class="icon teal shopping cart"></i> <Subscription query="subscription products_aggregate { schema: products_aggregate { aggregate { count(columns: id) } } }" print="schema.aggregate.count"></Subscription>
											</div>
											<div class="label">
												Products
											</div>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Page Views -->
                    <!-- Begin Messages -->
                    <div class="four wide computer sixteen wide phone centered column">
                        <div class="ui raised segment">
                            <div class="content">
                                <div class="ui centered grid">
                                    <div class="row">
										<div class="ui statistic">
											<div class="value">
												<i class="icon blue calculator"></i> <Subscription query="subscription purchases_aggregate { schema: purchases_aggregate { aggregate { count(columns: id) } } }" print="schema.aggregate.count"></Subscription>
											</div>
											<div class="label">
												Purchases
											</div>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Messages -->
                    <!-- Begin Downloads -->
                    <div class="four wide computer sixteen wide phone centered column">
                        <div class="ui raised segment">
                            <div class="content">
                                <div class="ui centered grid">
                                    <div class="row">
										<div class="ui statistic">
											<div class="value">
												<subscription query="subscription products_aggregate { schema: products_aggregate { aggregate { count(columns: id) } } }" print="schema.aggregate.count"></subscription>
											</div>
											<div class="label">
												Expiring Products
											</div>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Downloads -->
                    <!-- Begin Users -->
                    <div class="four wide computer sixteen wide phone centered column">
                        <div class="ui raised segment">
                            <div class="content">
                                <div class="ui centered grid">
                                    <div class="row">
										<div class="ui statistic">
											<div class="value">
												<subscription query="subscription expenses_aggregate { schema: expenses_aggregate { aggregate { count(columns: id) } } }" print="schema.aggregate.count"></subscription>
											</div>
											<div class="label">
												Expired Products
											</div>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Users -->
                    <!-- END STATISTIC ITEM -->

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