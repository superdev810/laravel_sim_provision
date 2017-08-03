@push('styles')
<link href="{{ URL::asset('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}"
      rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('/assets/global/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('/assets/global/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ URL::asset('/assets/global/plugins/jqvmap/jqvmap/jqvmap.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@extends('layouts.main')

@section('pagebar')
    @include('layouts.pagebar')
@endsection

@section('content')

    @if(Auth::guard('admins')->user())


        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-cursor font-purple"></i>
                            <span class="caption-subject font-purple bold uppercase">General Stats</span>
                        </div>
                        <div class="actions">
                            <a href="javascript:;" class="btn btn-sm btn-circle red easy-pie-chart-reload">
                                <i class="fa fa-repeat"></i> Reload </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="easy-pie-chart">
                                    <div class="number transactions" data-percent="55">
                                        <span>+55</span>%
                                    </div>
                                    <a class="title" href="javascript:;"> Transactions
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="margin-bottom-10 visible-sm"></div>
                            <div class="col-md-4">
                                <div class="easy-pie-chart">
                                    <div class="number visits" data-percent="85">
                                        <span>+85</span>%
                                    </div>
                                    <a class="title" href="javascript:;"> New Visits
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="margin-bottom-10 visible-sm"></div>
                            <div class="col-md-4">
                                <div class="easy-pie-chart">
                                    <div class="number bounce" data-percent="46">
                                        <span>-46</span>%
                                    </div>
                                    <a class="title" href="javascript:;"> Bounce
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-yellow"></i>
                            <span class="caption-subject font-yellow bold uppercase">Server Stats</span>
                            <span class="caption-helper">monthly stats...</span>
                        </div>
                        <div class="tools">
                            <a href="" class="collapse"> </a>
                            <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                            <a href="" class="reload"> </a>
                            <a href="" class="remove"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="sparkline-chart">
                                    <div class="number" id="sparkline_bar5"></div>
                                    <a class="title" href="javascript:;"> Network
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="margin-bottom-10 visible-sm"></div>
                            <div class="col-md-4">
                                <div class="sparkline-chart">
                                    <div class="number" id="sparkline_bar6"></div>
                                    <a class="title" href="javascript:;"> CPU Load
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="margin-bottom-10 visible-sm"></div>
                            <div class="col-md-4">
                                <div class="sparkline-chart">
                                    <div class="number" id="sparkline_line"></div>
                                    <a class="title" href="javascript:;"> Load Rate
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{$totalSimeFile}}">
                                {{$totalSimeFile}}
                            </span>
                        </div>
                        <div class="desc"> Upload total Sim File</div>
                    </div>
                    <a class="more" href="{{route('sim-contact')}}"> View more
                        <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat red">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup"
                                  data-value="{{$totalAddressFile}}">{{$totalAddressFile}}</span></div>
                        <div class="desc"> Upload Total Address File</div>
                    </div>
                    <a class="more" href="{{route('contact')}}"> View more
                        <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat green">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{$totalSim}}">{{$totalSim}}</span>
                        </div>
                        <div class="desc">Total Sim Data</div>
                    </div>
                    <a class="more" href="{{route('sim-list-page')}}"> View more
                        <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple">
                    <div class="visual">
                        <i class="fa fa-globe"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{$totalAddress}}"></span>
                        </div>
                        <div class="desc"> Total address</div>
                    </div>
                    <a class="more" href="{{route('contact-list-page')}}"> View more
                        <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="
                             @if(!empty($simStatus[\App\Models\SimInfo::PROCESS_PENDING]))
                            {{$simStatus[\App\Models\SimInfo::PROCESS_PENDING]}}
                            @else
                                    0
                                @endif
                            ">
                                @if(!empty($simStatus[\App\Models\SimInfo::PROCESS_PENDING]))
                                    {{$simStatus[\App\Models\SimInfo::PROCESS_PENDING]}}
                                @else
                                    0
                                @endif
                            </span>
                        </div>
                        <div class="desc">Total Pending</div>
                    </div>
                    <a class="more" href="{{route('report-pending')}}"> View more
                        <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat red">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                        <span data-counter="counterup" data-value="{{$totalSuccess}}">
                                {{$totalSuccess}}
                            </span>

                        </div>
                        <div class="desc"> Total Success</div>
                    </div>
                    <a class="more" href="{{route('report')}}"> View more
                        <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat green">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="
                             @if(!empty($simStatus[\App\Models\SimInfo::PROCESS_RETRY]))
                            {{$simStatus[\App\Models\SimInfo::PROCESS_RETRY]}}
                            @else
                                    0
                                @endif
                                    ">
                                @if(!empty($simStatus[\App\Models\SimInfo::PROCESS_RETRY]))
                                    {{$simStatus[\App\Models\SimInfo::PROCESS_RETRY]}}
                                @else
                                    0
                                @endif
                            </span>
                        </div>
                        <div class="desc">Total Retry</div>
                    </div>
                    <a class="more" href="{{route('report-retry')}}"> View more
                        <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple">
                    <div class="visual">
                        <i class="fa fa-globe"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="
                             @if(!empty($simStatus[\App\Models\SimInfo::PROCESS_FAILED]))
                            {{$simStatus[\App\Models\SimInfo::PROCESS_FAILED]}}
                            @else
                                    0
                            @endif
                                ">
                            @if(!empty($simStatus[\App\Models\SimInfo::PROCESS_FAILED]))
                                {{$simStatus[\App\Models\SimInfo::PROCESS_FAILED]}}
                            @else
                                0
                            @endif
                            </span>
                        </div>
                        <div class="desc"> Total Failed</div>
                    </div>
                    <a class="more" href="{{route('report-failed')}}"> View more
                        <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-6">
                <div id="container_1">

                </div>
            </div>

            <div class="col-md-6">
                <div id="container_2">

                </div>
            </div>
        </div>
        @endif


        </div>
@endsection


@push('scripts')
<script src="{{ URL::asset('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/morris/raphael-min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/counterup/jquery.waypoints.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/counterup/jquery.counterup.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/amcharts/amcharts/amcharts.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/amcharts/amcharts/serial.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/amcharts/amcharts/pie.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/amcharts/amcharts/radar.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/amcharts/amcharts/themes/light.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/amcharts/amcharts/themes/patterns.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/amcharts/amcharts/themes/chalk.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/amcharts/ammap/ammap.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/amcharts/amstockcharts/amstock.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/fullcalendar/fullcalendar.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/flot/jquery.flot.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/flot/jquery.flot.resize.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/flot/jquery.flot.categories.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('/assets/global/plugins/jquery.sparkline.min.js') }}" type="text/javascript"></script>

<script src="{{ URL::asset('/assets/pages/scripts/dashboard.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/pages/scripts/dashboard.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('/assets/pages/scripts/dashboard.min.js')}}" type="text/javascript"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script type="text/javascript">

    $(document).ready(function () {

        function get_hourly_report(obj) {
            $.getJSON(obj.route, function (json_data) {

                data = json_data[0];

                $(obj.domId).highcharts({
                    chart: {
                        zoomType: 'x',
                        type: 'area'
                    },
                    title: {
                        text:obj. title
                    },
                    subtitle: {
                        text: document.ontouchstart === undefined ?
                                'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
                    },
                    xAxis: {
                        categories: json_data[1]

                    },
                    yAxis: {
                        title: {
                            text: 'Uploded Information'
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        area: {
                            fillColor: {
                                linearGradient: {
                                    x1: 0,
                                    y1: 0,
                                    x2: 0,
                                    y2: 1
                                },
                                stops: [
                                    [0, Highcharts.getOptions().colors[0]],
                                    [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                ]
                            },
                            marker: {
                                radius: 2
                            },
                            lineWidth: 1,
                            states: {
                                hover: {
                                    lineWidth: 1
                                }
                            },
                            threshold: 0
                        }
                    },

                    series: [{
                        name: 'Clicks',
                        data: data
                    }]
                });

            });
        }


        get_hourly_report({
            route : '{{route('home-chart-sim')}}',
            domId : '#container_1',
            title : "Uploaded Sim Informations"
        });

        get_hourly_report({
            route : '{{route('home-chart-contact')}}',
            domId : '#container_2',
            title : "Uploaded  Address Information"
        });


    });


</script>

@endpush

