@extends('admin.app')

@section('title', trans('dashboard.dashboard'))

@section('content')


{{-- filter -------------------------------------------------------------------------------------------------------------------- --}}
@php 
 $search = request('start_date') != null || request('end_date') != null || request('order_status') != null;
@endphp
<div class="row mb-3 ">
    <div class="accordion accordion-flush" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="accordionFlushExample">
                <button class="accordion-button @if(!$search) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
                    @lang('dashboard.filter')
                </button>
            </h2>
            <div id="collapseFilter" class="accordion-collapse collapse @if($search) show @endif" aria-labelledby="headingFilter" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <form action="{{ route('admin.home') }}">
                        <div class="row my-3">
                            <div class="col-12 col-md-3">
                                <label for="start_date"> @lang('dashboard.start_date') </label>
                                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                            </div>
                            <div class="col-12 col-md-3">
                                <label for="start_date"> @lang('dashboard.end_date') </label>
                                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                            </div>
                            <div class="col-12 col-md-3">
                                <label for="start_date"> @lang('dashboard.order_status') </label>
                                <select class="form-control" name="order_status" value="{{ request('order_status') }}">
                                    <option value="">@lang('All')</option>
                                    <option value="0" {{ '0' ==  request('order_status') ? 'selected' : '' }}>@lang('Pending')</option>
                                    <option value="1" {{ 1 ==  request('order_status') ? 'selected' : '' }}>@lang('Confirmed')</option>
                                    <option value="3" {{ 3 ==  request('order_status') ? 'selected' : '' }}>@lang('Waiting')</option>
                                    <option value="4" {{ 4 ==  request('order_status') ? 'selected' : '' }}>@lang('Canceled')</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="submit" class="btn btn-primary btn-sm mt-4">@lang('button.save')</button>
                                <a href="{{ route('admin.home') }}" class="btn btn-danger btn-sm mt-4" data-hover="@lang('button.reset')"> <i class="bx bx-refresh"></i> </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


{{--  count of [donations- donor - message projects] --}}
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
    <div class="col">
        <a href="{{ route('admin.orders.index') }}">
            <div class="card radius-10 border-start border-0 border-4 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary"> @lang('dashboard.donations') </p>
                            <h4 class="my-1 text-info">{{ $orderCount }} </h4>
                            <p class="mb-0 font-13">{{ $lastMonthPercent }} @lang('dashboard.from_last_Month') </p>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto">
                            <i class='bx bxs-cart'></i>
                        </div>
                       
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col">
      <a href="{{ route('admin.donors.index') }}">
        <div class="card radius-10 border-start border-0 border-4 border-danger">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary"> @lang('dashboard.donors') </p>
                        <h4 class="my-1 text-danger">{{ $donorCount }}</h4>
                        <p class="mb-0 font-13">{{ $DonorMonth }} @lang('dashboard.from_last_Month') </p>
                    </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto"><i class='bx bx-user'></i>
                    </div>
                </div>
            </div>
        </div>
      </a>
    </div>
    <div class="col">
        <a href="{{ route('admin.contact-us.index') }}">
            <div class="card radius-10 border-start border-0 border-4 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary"> @lang('dashboard.messages') </p>
                            <h4 class="my-1 text-success"> {{ $contactsCount }} </h4>
                            <p class="mb-0 font-13">--</p>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bx-envelope'></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col">
        <a href="{{ route('admin.charity.projects.index') }}">
            <div class="card radius-10 border-start border-0 border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary"> @lang('dashboard.projects') </p>
                            <h4 class="my-1 text-warning"> {{ $projectsCount }} </h4>
                            <p class="mb-0 font-13"> -- </p>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i class='bx bxs-donate-heart'></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>


{{-- Donations chart & Most Project ordered --}}
<div class="row">
    <div class="col-12 col-lg-8 d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0">@lang('dashboard.donations')</h6>
                    </div>
                    <div class="ms-auto">
                        <span class="bg-success p-1 px-3 radius-10 text-white"> @lang('dashboard.total') : {{ $orderTotal }} </span>
                    </div>
                    {{-- <div class="dropdown ms-auto">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                            </li>
                        </ul>
                    </div> --}}
                </div>
            </div>
            <div class="card-body">
                {{-- <div class="d-flex align-items-center ms-auto font-13 gap-2 mb-3">
                    <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #14abef"></i>Sales</span>
                    <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #ffc107"></i>Visits</span>
                </div> --}}
                {{-- <div class="chart-container-1">
                    {!! $donationsChart->render() !!}
                </div> --}}
                <div class="x_content2">
                    <div id="donationChartOld" style="height: 260px;"></div>
                </div>
            </div>
            {{-- <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
                <div class="col">
                    <div class="p-3">
                        <h5 class="mb-0">24.15M</h5>
                        <small class="mb-0">Overall Visitor <span> <i class="bx bx-up-arrow-alt align-middle"></i> 2.43%</span></small>
                    </div>
                </div>
                <div class="col">
                    <div class="p-3">
                        <h5 class="mb-0">12:38</h5>
                        <small class="mb-0">Visitor Duration <span> <i class="bx bx-up-arrow-alt align-middle"></i> 12.65%</span></small>
                    </div>
                </div>
                <div class="col">
                    <div class="p-3">
                        <h5 class="mb-0">639.82</h5>
                        <small class="mb-0">Pages/Visit <span> <i class="bx bx-up-arrow-alt align-middle"></i> 5.62%</span></small>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="col-12 col-lg-4 d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0">@lang('dashboard.trending_projects')</h6>
                    </div>
                    {{-- <div class="dropdown ms-auto">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                            </li>
                        </ul>
                    </div> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container-2">
                    <canvas id="topProjectsChart"></canvas>
                </div>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($topProjects as $key => $item)
                    <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center border-top">
                        {{ @$item->project->trans?->first()->title }}
                        <span class="badge bg-{{ $colors[$key % count($colors)] }} rounded-pill"> {{$item->order_qty}} </span>
                    </li>
                @empty
                    
                @endforelse
            </ul>
        </div>
    </div>
</div>



{{-- Donations table  --}}
<div class="card radius-10">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div>
                <h6 class="mb-0"> @lang('dashboard.recent_orders') </h6>
            </div>
            {{-- <div class="dropdown ms-auto">
                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="javascript:;">Action</a>
                    </li>
                    <li><a class="dropdown-item" href="javascript:;">Another action</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                    </li>
                </ul>
            </div> --}}
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>@lang('orders.identifier')</th>
                        <th>@lang('orders.name')</th>
                        <th>@lang('orders.mobile')</th>
                        <th>@lang('orders.source')</th>
                        <th>@lang('orders.price')</th>
                        <th>@lang('orders.payment_methods')</th>
                        <th>@lang('admin.created_at')</th>
                        <th>@lang('admin.status')</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $payment = 'payment_method_'. app()->getLocale();
                    @endphp
                    @forelse($lastOrders as $key => $lastOrder)
                    <tr>
                        <td>#{{ $lastOrder->identifier }}</td>
                        <td>{{ $lastOrder->full_name }}</td>
                        <td>{{ $lastOrder->donor_mobile }}</td>
                        <td>{{ $lastOrder->source }}</td>
                        <td>{{ $lastOrder->total }}</td>
                        <td>{{ $lastOrder->$payment }}</td>
                        <td>{{ $lastOrder->created_at }}</td>
                        <td>
                            @switch ($lastOrder->status) 
                                @case('0')
                                    <span class="badge bg-gradient-blooker text-white shadow-sm w-100">@lang('Pending')</span>
                                    @break
                                @case(1)
                                    <span class="badge bg-gradient-quepal text-white shadow-sm w-100">@lang('Confirmed')</span>
                                    @break
                                @case(3)
                                    <span class="badge bg-gradient-waiting text-white shadow-sm w-100">@lang('Waiting')</span>
                                    @break
                                @case(4)
                                    <span class="badge bg-gradient-bloody text-white shadow-sm w-100">@lang('Canceled')</span>
                                    @break
                            @endswitch
                        </td>
                        
                    </tr>
                    @empty
                        
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Donations status Count -  Donations Source Count --}}
<div class="row row-cols-1 row-cols-lg-3">
    <div class="col d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0">@lang('dashboard.order_status')</h6>
                    </div>
                    {{-- <div class="dropdown ms-auto">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                            </li>
                        </ul>
                    </div> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container-1 mt-3">
                    <canvas id="orderStatusChart"></canvas>
                </div>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($orderStatusCount as $key => $orderStatus)
                @switch ($orderStatus->status) 
                    @case('0')
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                            @lang('Pending')
                            <span class="badge bg-gradient-blooker  rounded-pill">{{ $orderStatus->count }}</span>
                        </li>
                        @break
                    @case(1)
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center border-top">
                            @lang('Confirmed')
                            <span class="badge bg-gradient-quepal rounded-pill">{{ $orderStatus->count }}</span> 
                        </li>
                        @break
                    @case(3)
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                            @lang('Waiting')
                            <span class="badge bg-gradient-waiting rounded-pill">{{ $orderStatus->count }}</span>
                        </li>
                        @break
                    @case(4)
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                            @lang('Canceled')
                            <span class="badge bg-gradient-bloody rounded-pill">{{ $orderStatus->count }}</span>
                        </li>
                        @break
                @endswitch
                
                @empty
                    
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0">@lang('dashboard.order_source')</h6>
                    </div>
                 
                    {{-- <div class="dropdown ms-auto">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                            </li>
                        </ul>
                    </div> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container-1 mt-3">
                    <canvas id="orderSourceChart"></canvas>
                </div>
            </div>
            <ul class="list-group list-group-flush">

                @forelse($orderSourceCount as $key => $orderSource)
                    @switch ($orderSource->source) 
                        @case('web')
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                                @lang('dashboard.web')
                                <span class="badge bg-gradient-quepal  rounded-pill">{{ $orderSource->count }}</span>
                            </li>
                            @break
                        @case('app')
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center border-top">
                                @lang('dashboard.app')
                                <span class="badge bg-gradient-blooker rounded-pill">{{ $orderSource->count }}</span> 
                            </li>
                            @break
                        @case('badal')
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                                @lang('dashboard.badal')
                                <span class="badge bg-gradient-waiting rounded-pill">{{ $orderSource->count }}</span>
                            </li>
                            @break
                    @endswitch
                    
                @empty
                    
                @endforelse
            </ul>
        </div>
    </div>

    {{-- <div class="col d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0">Top Selling Categories</h6>
                    </div>
                    <div class="dropdown ms-auto">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container-0">
                    <canvas id="chart5"></canvas>
                </div>
            </div>
            <div class="row row-group border-top g-0">
                <div class="col">
                    <div class="p-3 text-center">
                        <h4 class="mb-0 text-danger">$45,216</h4>
                        <p class="mb-0">Clothing</p>
                    </div>
                </div>
                <div class="col">
                    <div class="p-3 text-center">
                        <h4 class="mb-0 text-success">$68,154</h4>
                        <p class="mb-0">Electronic</p>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div> --}}

</div>

@php
    foreach ($topProjects as $key => $topProject) {
        $topProjectsTrans[] = @$topProject->project->trans?->first()->title;
    }
    $statusArr = [
        '0' => __('Pending'),
        '1' =>  __('Confirmed'),
        '3' =>  __('Waiting'),
        '4' =>  __('Canceled'),
    ];
    foreach ($orderStatusCount as $key => $orderStatus) {
        $orderStatusTitle[] = @$statusArr[$orderStatus->status];
        $orderStatusQTY[] = $orderStatus->count;
    }

    $sourceArr = [
        'web' => __('dashboard.web'),
        'app' =>  __('dashboard.app'),
        'badal' =>  __('dashboard.badal'),
    ];

    foreach ($orderSourceCount as $key => $orderSource) {
        $orderSourceTitle[] = @$sourceArr[$orderSource->source];
        $orderSourceQTY[] = $orderSource->count;
    }

@endphp

@endsection


@section('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" rel="stylesheet">
@endsection

@section('script')
    {{-- @vite(['resources/assets/admin/app-charts.js']) --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <script>
        $(function() {


            const donationsData = JSON.parse('<?php echo json_encode($donationsData); ?>');

            let charDay = [];
            let charTotal = [];
            let charCount = [];
            let chartData = '';
            donationsData.forEach(donation => {
                charDay.push(`${donation.created_date}`);
                charTotal.push(`${donation.total}`);
                charCount.push(`${donation.count}`);
                chartData += `{ day: '${donation.created_date}', total: '${donation.total}', count: '${donation.count}' },`;

            });

            // old  =============================================================================================================================
            
            new Morris.Line({
                // ID of the element in which to draw the chart.
                element: 'donationChartOld',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data: [
                    <?php
                    foreach ($donationsData as $donation) {
                        echo "{
                        day: '" . $donation['created_date'] . "',
                        total: " . $donation['total'] . ",
                        count: " . $donation['count'] . ",
                        },";
                    }
                    ?>
                ],
                // The name of the data record attribute that contains x-values.
                xLabels: 'day',
                xkey: ['day'],
                // A list of names of data record attributes that contain y-values.
                ykeys: ['total', 'count'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['القيمة الاجمالية بالريال', ' عدد التبرعات '],
                lineColors: ['#9B59B6', '#3498DB']
            });
        });
    </script>


    <script>
        $(function() {

            const topProjectsTrans = JSON.parse('<?php  echo json_encode(@$topProjectsTrans ?? [] ); ?>');
            const topProjectsQty = JSON.parse('<?php echo json_encode(@$topProjects->pluck("order_qty") ?? []); ?>');
     
            var ctx = document.getElementById("topProjectsChart").getContext('2d');

            var gradientStroke4 = ctx.createLinearGradient(0, 0, 0, 300);
                gradientStroke4.addColorStop(0, '#ffc107');
                gradientStroke4.addColorStop(1, '#ffc107');

            var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
                gradientStroke3.addColorStop(0, '#4776e6');
                gradientStroke3.addColorStop(1, '#8e54e9');


            var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
                gradientStroke2.addColorStop(0, '#ee0979');
                gradientStroke2.addColorStop(1, '#ff6a00');
                
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
                gradientStroke1.addColorStop(0, '#42e695');
                gradientStroke1.addColorStop(1, '#078a0f');

                var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: topProjectsTrans,
                    datasets: [{
                    backgroundColor: [
                        gradientStroke1,
                        gradientStroke2,
                        gradientStroke3,
                        gradientStroke4
                    ],
                    hoverBackgroundColor: [
                        gradientStroke1,
                        gradientStroke2,
                        gradientStroke3,
                        gradientStroke4
                    ],
                    data: topProjectsQty,
                    borderWidth: [1, 1, 1, 1]
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutout: 82,
                    plugins: {
                    legend: {
                        display: false,
                    }
                    }
                    
                }
            });
        });
    </script>


    <script>
        $(function() {

            const orderSourceTitle = JSON.parse('<?php  echo json_encode(@$orderSourceTitle??[]); ?>');
            const orderSourceQTY = JSON.parse('<?php  echo json_encode(@$orderSourceQTY??[]); ?>');


            var ctx = document.getElementById("orderSourceChart").getContext('2d');

           
            var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
                gradientStroke3.addColorStop(0, '#ffc107');
                gradientStroke3.addColorStop(1, '#ffc107');

            var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
                gradientStroke2.addColorStop(0, '#4776e6');
                gradientStroke2.addColorStop(1, '#8e54e9');


            var gradientStroke4 = ctx.createLinearGradient(0, 0, 0, 300);
                gradientStroke4.addColorStop(0, '#ee0979');
                gradientStroke4.addColorStop(1, '#ff6a00');
                
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
                gradientStroke1.addColorStop(0, '#42e695');
                gradientStroke1.addColorStop(1, '#078a0f');

                var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: orderSourceTitle,
                    datasets: [{
                    backgroundColor: [
                        gradientStroke1,
                        gradientStroke2,
                        gradientStroke3,
                        gradientStroke4,
                    ],

                    hoverBackgroundColor: [
                        gradientStroke1,
                        gradientStroke2,
                        gradientStroke3,
                        gradientStroke4,
                    ],

                    data: orderSourceQTY,
                borderWidth: [1, 1, 1]
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutout: 95,
                    plugins: {
                    legend: {
                        display: false,
                    }
                    }
                    
                }
                });
        });
    </script>


    <script>
        $(function() {

            const orderStatusTitle = JSON.parse('<?php  echo json_encode(@$orderStatusTitle??[]); ?>');
            const orderStatusQTY = JSON.parse('<?php  echo json_encode(@$orderStatusQTY??[]); ?>');


            var ctx = document.getElementById("orderStatusChart").getContext('2d');

           
            var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
                gradientStroke3.addColorStop(0, '#ffc107');
                gradientStroke3.addColorStop(1, '#ffc107');

            var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
                gradientStroke2.addColorStop(0, '#4776e6');
                gradientStroke2.addColorStop(1, '#8e54e9');


            var gradientStroke4 = ctx.createLinearGradient(0, 0, 0, 300);
                gradientStroke4.addColorStop(0, '#ee0979');
                gradientStroke4.addColorStop(1, '#ff6a00');
                
            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
                gradientStroke1.addColorStop(0, '#42e695');
                gradientStroke1.addColorStop(1, '#078a0f');

                var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: orderStatusTitle,
                    datasets: [{
                    backgroundColor: [
                        gradientStroke1,
                        gradientStroke2,
                        gradientStroke3,
                        gradientStroke4,
                    ],

                    hoverBackgroundColor: [
                        gradientStroke1,
                        gradientStroke2,
                        gradientStroke3,
                        gradientStroke4,
                    ],

                    data: orderStatusQTY,
                borderWidth: [1, 1, 1]
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutout: 95,
                    plugins: {
                    legend: {
                        display: false,
                    }
                    }
                    
                }
                });
        });
    </script>
@endsection
