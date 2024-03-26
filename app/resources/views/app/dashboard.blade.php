@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/chartist.css">
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/rating.css">
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/lds-animate.css">
<style>
    .text-camel{
        text-transform: capitalize
    }
    .fc-h-event .fc-event-title{
        white-space: normal;
    }
</style>
@if($DashboardType=='admin')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{url('/')}}/admin"><i class="f-16 fa fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item text-camel">Dashboard</li>
                        <li class="breadcrumb-item  text-camel">{{$DashboardType}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid fs-13">
        
        <div class="row">
            <div class="col-sm-12 col-md-6 box-col-12 fs-13">
                <div class="card card-with-border">
                    <div class="card-header p-10">
                        <div class="row">
                            <div class="col-12 col-md-8"><div class="card-title fw-600 fs-15">Customers Outstanding</div> </div>
                            <div class="col-12 col-md-4 d-flex justify-content-end align-items-center pr-10"><span class="full-right fs-14 fw-600"><a href="#">View</a></span></div>
                        </div>
                    </div>
                    <div class="card-body p-0 m-0">
                        <div class="row project-details m-0 social-row py-4 d-flex justify-content-center">
                            <div class="col-sm-12 col-12 col-md-4">
                                <div class="project-incomes text-center">
                                    <i class="fa fa-shopping-cart fs-24 txt-warning"></i>
                                    <h6 class="mb-0 mt-20">Orders Values</h6>
                                    <p class="mb-0 mt-10 fw-600 ldsEllipsis" id="divCustomerOrderValues">0</p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-12 col-md-4">
                                <div class="project-incomes text-center">
                                    
                                    <i class="fa fa-check-circle fs-24 txt-success"></i>
                                    <h6 class="mb-0 mt-20">Received</h6>
                                    <p class="mb-0 mt-10 fw-600 ldsEllipsis" id="divCustomerReceived">0</p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-12 col-md-4">
                                <div class="project-incomes text-center">
                                    <i class="fa fa-exclamation-circle fs-24 txt-danger"></i>
                                    <h6 class="mb-0 mt-20">Outstanding</h6>
                                    <p class="mb-0 mt-10 fw-600 ldsEllipsis" id="divCustomerOutstandings">0</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 box-col-12 fs-13">
                <div class="card card-with-border">
                    <div class="card-header p-10">
                        <div class="row">
                            <div class="col-12 col-md-8"><div class="card-title fw-600 fs-16">Vendor Outstanding</div> </div>
                            <div class="col-12 col-md-4 d-flex justify-content-end align-items-center pr-10"><span class="full-right fs-14 fw-600"><a href="#">View</a></span></div>
                        </div>
                    </div>
                    <div class="card-body p-0 m-0">
                        <div class="row project-details m-0 social-row py-4 d-flex justify-content-center">
                            <div class="col-sm-12 col-12 col-md-4">
                                <div class="project-incomes text-center">
                                    <i class="fa fa-shopping-cart fs-24 txt-warning"></i>
                                    <h6 class="mb-0 mt-20">Orders Values</h6>
                                    <p class="mb-0 mt-10 fw-600 ldsEllipsis"  id="divVendorOrderValues">0</p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-12 col-md-4">
                                <div class="project-incomes text-center">
                                    
                                    <i class="fa fa-check-circle fs-24 txt-success"></i>
                                    <h6 class="mb-0 mt-20">Paid</h6>
                                    <p class="mb-0 mt-10 fw-600 ldsEllipsis" id="divVendorPaid">0</p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-12 col-md-4">
                                <div class="project-incomes text-center">
                                    <i class="fa fa-exclamation-circle fs-24 txt-danger"></i>
                                    <h6 class="mb-0 mt-20">Outstanding</h6>
                                    <p class="mb-0 mt-10 fw-600 ldsEllipsis" id="divVendorOutstanding">0</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="card investments">
                    <div class="card-header p-10">
                        <div class="row">
                            <div class="col-12 col-md-8"><div class="card-title fw-600 fs-15">Quote Enquiry</div> </div>
                            <div class="col-12 col-md-4 d-flex justify-content-end align-items-center pr-10"><span class="full-right fs-14 fw-600"><a href="#">View</a></span></div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-sm-12 pb-20 d-flex justify-content-center align-items-center mh-350" id="divEnquiryCircleChart">
                                <div id="EnquiryCircleChart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0" id="divEnquiryCircleChartStats">
                        <ul>
                            <li class="text-center"><span class="f-12">Last Month</span>
                                <h6 class="f-w-600 mb-0 last-month">0</h6>
                            </li>
                            <li class="text-center"><span class="f-12">Today</span>
                                <h6 class="f-w-600 mb-0 today">0</h6>
                            </li>
                            <li class="text-center"><span class="f-12">This Week</span>
                                <h6 class="f-w-600 mb-0 this-week">0</h6>
                            </li>
                            <li class="text-center"><span class="f-12">This Month</span>
                                <h6 class="f-w-600 mb-0 this-month">0</h6>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card investments">
                    <div class="card-header p-10">
                        <div class="row">
                            <div class="col-12 col-md-8"><div class="card-title fw-600 fs-15">Orders</div> </div>
                            <div class="col-12 col-md-4 d-flex justify-content-end align-items-center pr-10"><span class="full-right fs-14 fw-600"><a href="#">View</a></span></div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-sm-12 pb-20 d-flex justify-content-center align-items-center mh-350"  id="divOrdersCircleChart">
                                <div id="OrderCircleChart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0"  id="divOrdersCircleChartStats">
                        <ul>
                            <li class="text-center"><span class="f-12">Last Month</span>
                                <h6 class="f-w-600 mb-0 last-month">0</h6>
                            </li>
                            <li class="text-center"><span class="f-12">Today</span>
                                <h6 class="f-w-600 mb-0 today">0</h6>
                            </li>
                            <li class="text-center"><span class="f-12">This Week</span>
                                <h6 class="f-w-600 mb-0 this-week">0</h6>
                            </li>
                            <li class="text-center"><span class="f-12">This Month</span>
                                <h6 class="f-w-600 mb-0 this-month">0</h6>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card investments">
                    <div class="card-header p-10">
                        <div class="row">
                            <div class="col-12 col-md-8"><div class="card-title fw-600 fs-15">Delivery</div> </div>
                            <div class="col-12 col-md-4 d-flex justify-content-end align-items-center pr-10"><span class="full-right fs-14 fw-600"><a href="#">View</a></span></div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-sm-12 pb-20 d-flex justify-content-center align-items-center mh-350"  id="divDeliveryCircleChart">
                                <div id="DeliveryCircleChart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0"  id="divDeliveryCircleChartStats">
                        <ul>
                            <li class="text-center"><span class="f-12">Today</span>
                                <h6 class="f-w-600 mb-0 today">0</h6>
                            </li>
                            <li class="text-center"><span class="f-12">Tomorrow</span>
                                <h6 class="f-w-600 mb-0 tomorrow">0</h6>
                            </li>
                            <li class="text-center"><span class="f-12">This Week</span>
                                <h6 class="f-w-600 mb-0 this-week">0</h6>
                            </li>
                            <li class="text-center"><span class="f-12">This Month</span>
                                <h6 class="f-w-600 mb-0 this-month">0</h6>
                            </li>
                            <li class="text-center"><span class="f-12">Next Month</span>
                                <h6 class="f-w-600 mb-0 next-month">0</h6>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-4">
                <div class="card investments">
                    <div class="card-header p-10">
                        <div class="row">
                            <div class="col-12 col-md-8"><div class="card-title fw-600 fs-15">Customer</div> </div>
                            <div class="col-12 col-md-4 d-flex justify-content-end align-items-center pr-10"><span class="full-right fs-14 fw-600"><a href="#">View</a></span></div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-sm-12 pb-20 d-flex justify-content-center align-items-center mh-350" id="divCustomerPieChart">
                               <canvas id="CustomerPieChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0" id="divCustomerPieChartStats" >
                        <ul>
                            <li class="text-center"><span class="f-12">Active</span>
                                <h6 class="f-w-600 mb-0 active text-success">0</h6>
                            </li>
                            <li class="text-center"><span class="f-12">Inactive</span>
                                <h6 class="f-w-600 mb-0 inactive text-warning">0</h6>
                            </li>
                            <li class="text-center"><span class="f-12">Deleted</span>
                                <h6 class="f-w-600 mb-0 deleted text-danger">0</h6>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card investments">
                    <div class="card-header p-10">
                        <div class="row">
                            <div class="col-12 col-md-8"><div class="card-title fw-600 fs-15">Vendors</div> </div>
                            <div class="col-12 col-md-4 d-flex justify-content-end align-items-center pr-10"><span class="full-right fs-14 fw-600"><a href="#">View</a></span></div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-sm-12 pb-20 d-flex justify-content-center align-items-center mh-350"  id="divVendorPieChart">
                                <canvas id="VendorPieChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0" id="divVendorPieChartStats">
                        <ul>
                            <li class="text-center"><span class="f-12">Active</span>
                                <h6 class="f-w-600 mb-0 active text-success">0</h6>
                            </li>
                            <li class="text-center"><span class="f-12">Inactive</span>
                                <h6 class="f-w-600 mb-0 inactive text-warning">0</h6>
                            </li>
                            <li class="text-center"><span class="f-12">Deleted</span>
                                <h6 class="f-w-600 mb-0 deleted text-danger">0</h6>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card investments">
                    <div class="card-header p-10">
                        <div class="row">
                            <div class="col-12 col-md-8"><div class="card-title fw-600 fs-15">Employees</div> </div>
                            <div class="col-12 col-md-4 d-flex justify-content-end align-items-center pr-10"><span class="full-right fs-14 fw-600"><a href="#">View</a></span></div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-sm-12 pb-20 d-flex justify-content-center align-items-center mh-350" id="divEmployeePieChart">
                                <canvas id="EmployeePieChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0" id="divEmployeePieChartStats">
                        <ul>
                            <li class="text-center"><span class="f-12">Active</span>
                                <h6 class="f-w-600 mb-0 active text-success">0</h6>
                            </li>
                            <li class="text-center"><span class="f-12">Inactive</span>
                                <h6 class="f-w-600 mb-0 inactive text-warning">0</h6>
                            </li>
                            <li class="text-center"><span class="f-12">Deleted</span>
                                <h6 class="f-w-600 mb-0 deleted text-danger">0</h6>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header p-10">
                        <div class="row">
                            <div class="col-12 col-md-8"><div class="card-title fw-600 fs-16">Recent Quote Enquiry</div> </div>
                            <div class="col-12 col-md-4 d-flex justify-content-end align-items-center pr-10"><span class="full-right fs-14 fw-600"><a href="#">View</a></span></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table" id="tblQuoteEnquiry">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Enquiry No</th>
                                            <th class="text-center">Enquiry Date</th>
                                            <th class="text-center">Customer Name</th>
                                            <th class="text-center">Contact Number</th>
                                            <th class="text-center">Expected Delivery</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center noExport">action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header p-10">
                        <div class="row">
                            <div class="col-12 col-md-8"><div class="card-title fw-600 fs-16">Recent Orders</div> </div>
                            <div class="col-12 col-md-4 d-flex justify-content-end align-items-center pr-10"><span class="full-right fs-14 fw-600"><a href="#">View</a></span></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-sm" id="tblOrders">
                                    <thead>
                                        <tr class="valign-top">
                                            <th class="text-center">Order No</th>
                                            <th class="text-center">Order Date</th>
                                            <th class="text-center">Customer Name</th>
                                            <th class="text-center">Contact Number</th>
                                            <th class="text-center">Expected Date</th>
                                            <th class="text-center">Order Amount</th>
                                            <th class="text-center">Paid Amount</th>
                                            <th class="text-center">Balance</th>
                                            <th class="text-center">Order Status</th>
                                            <th class="text-center">Payment Status</th>
                                            <th class="text-center noExport">action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header"><h5 class="card-title"> Order Stats <span class="fs-13">({{date($Settings['date-format'],strtotime($FY->FromDate))}} - {{date($Settings['date-format'],strtotime($FY->ToDate))}})</span></h5> </div>
                    <div class="card-body  pt-10 pb-10">
                        <div class="row">
                            <div class="col-sm-12 pb-20">
                                <div class="chart-overflow" id="QuoteEnquiryBar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header"><h5 class="card-title"> Payments & Receipts Stats <span class="fs-13">({{date($Settings['date-format'],strtotime($FY->FromDate))}} - {{date($Settings['date-format'],strtotime($FY->ToDate))}})</span></h5></div>
                    <div class="card-body  pt-10 pb-10">
                        <div class="row">
                            <div class="col-sm-12 pb-20">
                                <div class="chart-overflow" id="PaymentsBar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header"><h5 class="card-title"> Upcoming Payment & Receipts </h5></div>
                    <div class="card-body  pt-10 pb-10">
                        <div class="row">
                            <div class="col-sm-12 pb-20">
                                <div id='calendar'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
@section('scripts')
    <script src="{{url('/')}}/assets/js/chart/google/google-chart-loader.js"></script>
    <script src="{{url('/')}}/assets/js/chart/chartist/chartist.js"></script>
    <script src="{{url('/')}}/assets/js/chart/chartist/chartist-plugin-tooltip.js"></script>
    <script src="{{url('/')}}/assets/js/chart/apex-chart/apex-chart.js"></script>
    <script src="{{url('/')}}/assets/js/chart/apex-chart/stock-prices.js"></script>
    <script src="{{url('/')}}/assets/js/counter/jquery.waypoints.min.js"></script>
    <script src="{{url('/')}}/assets/js/counter/jquery.counterup.min.js"></script>
    <script src="{{url('/')}}/assets/js/counter/counter-custom.js"></script>
    <script src="{{url('/')}}/assets/js/rating/jquery.barrating.js"></script>
    <script src="{{url('/')}}/assets/js/rating/rating-script.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
    <script>
        $(document).ready(function(){
            const animationLoaders={
                ellipsis:'<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>',
                facebook:'<div class="lds-facebook"><div></div><div></div><div></div><div></div></div>',
                spinner:'<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
                svgSpinner:'<svg xmlns="http://www.w3.org/2000/svg"  height="200px" viewBox="0 0 200 200"><linearGradient id="a11"><stop offset="0" stop-color="#FF156D" stop-opacity="0"></stop><stop offset="1" stop-color="#FF156D"></stop></linearGradient><circle fill="none" stroke="url(#a11)" stroke-width="22" stroke-linecap="round" stroke-dasharray="0 44 0 44 0 44 0 44 0 360" cx="100" cy="100" r="70" transform-origin="center"><animateTransform type="rotate" attributeName="transform" calcMode="discrete" dur="2" values="360;324;288;252;216;180;144;108;72;36" repeatCount="indefinite"></animateTransform></circle></svg>',
                svgRipples:"<svg xmlns='http://www.w3.org/2000/svg'  height='200px' viewBox='0 0 200 200'><circle fill='none' stroke-opacity='1' stroke='#FF156D' stroke-width='.5' cx='100' cy='100' r='0'><animate attributeName='r' calcMode='spline' dur='2' values='1;80' keyTimes='0;1' keySplines='0 .2 .5 1' repeatCount='indefinite'></animate><animate attributeName='stroke-width' calcMode='spline' dur='2' values='0;25' keyTimes='0;1' keySplines='0 .2 .5 1' repeatCount='indefinite'></animate><animate attributeName='stroke-opacity' calcMode='spline' dur='2' values='1;0' keyTimes='0;1' keySplines='0 .2 .5 1' repeatCount='indefinite'></animate></circle></svg>"
            }
            const init=async()=>{
                loadCalendar();
                getDashboardStats();
                getRecentQuoteEnquiry();
                getRecentOrders();
                loadEnquiryCircleChart();
                loadOrdersCircleChart();
                loadDeliveryCircleChart();
            }
            const loadEnquiryCircleChart=async()=>{
                const getData=async()=>{
                    return new Promise(async(resolve,reject)=>{
                        $.ajax({
                            type:"post",
                            url:"{{route('admin.dashboard.get.circle.stats.enquiry')}}",
                            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                            dataType:"json",
                            async:true,
                            error:(e, x, settings, exception)=>{resolve([0, 0, 0, 0]);},
                            success:function(data){
                                resolve(data);
                            }
                        });
                    });
                }
                $('#divEnquiryCircleChart').append('<div class="load-animation">'+animationLoaders.svgRipples+'</div>');
                let jsonData=await getData();
                $('#divEnquiryCircleChartStats .lastmonth').html(jsonData.lastMonth)
                $('#divEnquiryCircleChartStats .today').html(jsonData.today)
                $('#divEnquiryCircleChartStats .this-week').html(jsonData.thisWeek)
                $('#divEnquiryCircleChartStats .this-month').html(jsonData.thisMonth)
                var options = {
                        chart: {
                            height: 350,
                            type: 'radialBar',
                        },
                        plotOptions: {
                            radialBar: {
                                dataLabels: {
                                    name: {
                                        fontSize: '18px',
                                    },
                                    value: {
                                        fontSize: '14px',
                                    },
                                    total: {
                                        show: true,
                                        label: 'Today',
                                        formatter: function (w) {
                                            return jsonData.today
                                        }
                                    }
                                }
                            }
                        },
                        series: [jsonData.lastMonth, jsonData.today, jsonData.thisWeek, jsonData.thisMonth],
                        labels: ['Last Month', 'Today', 'This Week', 'This Month'],
                        colors:['#655af3', '#fd2e64', '#51bb25', '#7a15f7']


                    }

                var EnquiryCircleChart = new ApexCharts(
                    document.querySelector("#EnquiryCircleChart"),
                    options
                );
                $('#divEnquiryCircleChart .load-animation').remove();
                EnquiryCircleChart.render();
            }
            const loadOrdersCircleChart=async()=>{
                const getData=async()=>{
                    return new Promise(async(resolve,reject)=>{
                        $.ajax({
                            type:"post",
                            url:"{{route('admin.dashboard.get.circle.stats.orders')}}",
                            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                            dataType:"json",
                            async:true,
                            error:(e, x, settings, exception)=>{resolve([0, 0, 0, 0]);},
                            success:function(data){
                                resolve(data);
                            }
                        });
                    });
                }
                $('#divOrdersCircleChart').append('<div class="load-animation">'+animationLoaders.svgRipples+'</div>');
                let jsonData=await getData();
                $('#divOrdersCircleChartStats .lastmonth').html(jsonData.lastMonth)
                $('#divOrdersCircleChartStats .today').html(jsonData.today)
                $('#divOrdersCircleChartStats .this-week').html(jsonData.thisWeek)
                $('#divOrdersCircleChartStats .this-month').html(jsonData.thisMonth)
                var options = {
                        chart: {
                            height: 350,
                            type: 'radialBar',
                        },
                        plotOptions: {
                            radialBar: {
                                dataLabels: {
                                    name: {
                                        fontSize: '18px',
                                    },
                                    value: {
                                        fontSize: '14px',
                                    },
                                    total: {
                                        show: true,
                                        label: 'Today',
                                        formatter: function (w) {
                                            return jsonData.today
                                        }
                                    }
                                }
                            }
                        },
                        series: [jsonData.lastMonth, jsonData.today, jsonData.thisWeek, jsonData.thisMonth],
                        labels: ['Last Month', 'Today', 'This Week', 'This Month'],
                        colors:['#655af3', '#fd2e64', '#51bb25', '#7a15f7']


                    }

                var OrderCircleChart = new ApexCharts(
                    document.querySelector("#OrderCircleChart"),
                    options
                );
                $('#divOrdersCircleChart .load-animation').remove();
                OrderCircleChart.render();
            }
            const loadDeliveryCircleChart=async()=>{
                const getData=async()=>{
                    return new Promise(async(resolve,reject)=>{
                        $.ajax({
                            type:"post",
                            url:"{{route('admin.dashboard.get.circle.stats.delivery')}}",
                            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                            dataType:"json",
                            async:true,
                            error:(e, x, settings, exception)=>{resolve([0, 0, 0, 0]);},
                            success:function(data){
                                resolve(data);
                            }
                        });
                    });
                }
                $('#divDeliveryCircleChart').append('<div class="load-animation">'+animationLoaders.svgRipples+'</div>');
                let jsonData=await getData();
                $('#divDeliveryCircleChartStats .nextMonth').html(jsonData.nextMonth)
                $('#divDeliveryCircleChartStats .today').html(jsonData.today)
                $('#divDeliveryCircleChartStats .tomorrow').html(jsonData.tomorrow)
                $('#divDeliveryCircleChartStats .this-week').html(jsonData.thisWeek)
                $('#divDeliveryCircleChartStats .this-month').html(jsonData.thisMonth)
                var options = {
                        chart: {
                            height: 350,
                            type: 'radialBar',
                        },
                        plotOptions: {
                            radialBar: {
                                dataLabels: {
                                    name: {
                                        fontSize: '18px',
                                    },
                                    value: {
                                        fontSize: '14px',
                                    },
                                    total: {
                                        show: true,
                                        label: 'Today',
                                        formatter: function (w) {
                                            return jsonData.today
                                        }
                                    }
                                }
                            }
                        },
                        series: [jsonData.today, jsonData.tomorrow, jsonData.thisWeek, jsonData.thisMonth,jsonData.nextMonth],
                        labels: [ 'Today', 'Tomorrow', 'This Week','This Month','Next Month'],
                        colors:['#655af3', '#fd2e64', '#51bb25', '#7a15f7', "#ff5f24"]


                    }

                var DeliveryCircleChart = new ApexCharts(
                    document.querySelector("#DeliveryCircleChart"),
                    options
                );
                $('#divDeliveryCircleChart .load-animation').remove();
                DeliveryCircleChart.render();
            }
            const getDashboardStats=async()=>{
                const loadCustomerPieChart=async(data)=>{
                    let ctx = document.getElementById('CustomerPieChart');
                    let pieLabels = ["Active", "Inactive", "Deleted"];
                    let pieData = [data.customer.stats.active, data.customer.stats.inactive, data.customer.stats.deleted];
                    let pieColors=["#51bb25","#ff5f24","#fd2e64"];
                    let config={
                            type: 'doughnut',
                            data: {
                                labels: pieLabels,
                                datasets: [
                                    {
                                        data: pieData,
                                        backgroundColor: pieColors
                                    }
                                ]
                            },
                            options: {
                                maintainAspectRatio: false
                            }
                        }
                    $('#divCustomerPieChart .load-animation').remove()
                    $('#CustomerPieChart').show();
                    let pieChart = new Chart(ctx, config);
                }
                const loadVendorPieChart=async(data)=>{
                    let ctx = document.getElementById('VendorPieChart');
                    let pieLabels = ["Active", "Inactive", "Deleted"];
                    let pieData = [data.vendor.stats.active, data.vendor.stats.inactive, data.vendor.stats.deleted];
                    let pieColors=["#51bb25","#ff5f24","#fd2e64"];
                    let config={
                            type: 'doughnut',
                            data: {
                                labels: pieLabels,
                                datasets: [
                                    {
                                        data: pieData,
                                        backgroundColor: pieColors
                                    }
                                ]
                            },
                            options: {
                                maintainAspectRatio: false
                            }
                        }
                    $('#divVendorPieChart .load-animation').remove()
                    $('#VendorPieChart').show();
                    let pieChart = new Chart(ctx, config);
                }
                const loadEmployeePieChart=async(data)=>{
                    let ctx = document.getElementById('EmployeePieChart');
                    let pieLabels = ["Active", "Inactive", "Deleted"];
                    let pieData = [data.vendor.stats.active, data.vendor.stats.inactive, data.vendor.stats.deleted];
                    let pieColors=["#51bb25","#ff5f24","#fd2e64"];
                    let config={
                            type: 'doughnut',
                            data: {
                                labels: pieLabels,
                                datasets: [
                                    {
                                        data: pieData,
                                        backgroundColor: pieColors
                                    }
                                ]
                            },
                            options: {
                                maintainAspectRatio: false
                            }
                        }
                    $('#divEmployeePieChart .load-animation').remove()
                    $('#EmployeePieChart').show();
                    let pieChart = new Chart(ctx, config);
                }
                $('#divCustomerPieChart').append('<div class="load-animation">'+animationLoaders.svgRipples+'</div>');
                $('#divVendorPieChart').append('<div class="load-animation">'+animationLoaders.svgRipples+'</div>');
                $('#divEmployeePieChart').append('<div class="load-animation">'+animationLoaders.svgRipples+'</div>');
                $('#CustomerPieChart').hide();
                $('#VendorPieChart').hide();
                $('#EmployeePieChart').hide();
                $.ajax({
                    type:"post",
                    url:"{{route('admin.dashboard.get.dashboard-stats')}}",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    dataType:"json",
                    async:true,
                    beforeSend:function(){
                        $('.ldsEllipsis').html(animationLoaders.ellipsis);
                    },
                    success:function(data){
                        loadCustomerPieChart(data);
                        loadVendorPieChart(data);
                        loadEmployeePieChart(data);
                        ///Customers stats
                        $('#divCustomerPieChartStats .active').html(data.customer.stats.active);
                        $('#divCustomerPieChartStats .inactive').html(data.customer.stats.inactive);
                        $('#divCustomerPieChartStats .deleted').html(data.customer.stats.deleted);
                        //vendor stats
                        $('#divVendorPieChartStats .active').html(data.vendor.stats.active);
                        $('#divVendorPieChartStats .inactive').html(data.vendor.stats.inactive);
                        $('#divVendorPieChartStats .deleted').html(data.vendor.stats.deleted);
                        //employee stats
                        $('#divEmployeePieChartStats .active').html(data.employee.stats.active);
                        $('#divEmployeePieChartStats .inactive').html(data.employee.stats.inactive);
                        $('#divEmployeePieChartStats .deleted').html(data.employee.stats.deleted);

                        //customer outstandings
                        $('#divCustomerOrderValues').html(data.customer.orderValues);
                        $('#divCustomerReceived').html(data.customer.received);
                        $('#divCustomerOutstandings').html(data.customer.outstanding);
                        ///Vendors outstanding
                        $('#divVendorOrderValues').html(data.vendor.orderValues);
                        $('#divVendorPaid').html(data.vendor.paid);
                        $('#divVendorOutstanding').html(data.vendor.outstanding);
                    }
                });
            }
            const getRecentQuoteEnquiry = async () => {
                $('#tblQuoteEnquiry').dataTable({
                    "bProcessing": true,
                    "bServerSide": true,
                    "ajax": {
                        "url": "{{route('admin.dashboard.get.recent.quote-enquiry')}}?_token="+$('meta[name=_token]').attr('content'),
                        "headers": {
                            'X-CSRF-Token': $('meta[name=_token]').attr('content')
                        },
                        data:{
                            length:10
                        },
                        "type": "POST"
                    },
                    deferRender: true,
                    responsive: true,
                    dom: 'Bfrtip',
                    order: [[0, 'desc']],
                    iDisplayLength: 10,
                    lengthMenu: [[10, 25, 50, 100, 250, 500, -1], [10, 25, 50, 100, 250, 500, "All"]],
                    buttons: [],
                    searching: false,
                    info: false,
                    paging: false,
                    columnDefs: [
                        {"className": "dt-center", "targets": [6, 7]}
                    ]
                });
            }

            const getRecentOrders = async () => {
                $('#tblOrders').dataTable({
                    "bProcessing": true,
                    "bServerSide": true,
                    "ajax": {
                        "url": "{{route('admin.dashboard.get.recent.orders')}}?_token="+$('meta[name=_token]').attr('content'),
                        "headers": {
                            'X-CSRF-Token': $('meta[name=_token]').attr('content')
                        },
                        data:{
                            length:10
                        },
                        "type": "POST"
                    },
                    deferRender: true,
                    responsive: true,
                    dom: 'Bfrtip',
                    order: [[0, 'desc']],
                    iDisplayLength: 10,
                    lengthMenu: [[10, 25, 50, 100, 250, 500, -1], [10, 25, 50, 100, 250, 500, "All"]],
                    buttons: [],
                    searching: false,
                    info: false,
                    paging: false,
                    columnDefs: [
                        {"className": "dt-center", "targets": [6, 7]}
                    ]
                });
            }
            const loadCharts=async()=>{
                const loadQuoteEnquiryBar=async()=>{
                    const getData=async()=>{
                        return new Promise(async(resolve,reject)=>{
                            $.ajax({
                                type:"post",
                                url:"{{route('admin.dashboard.get.orders.stats')}}",
                                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                                dataType:"json",
                                async:true,
                                error:(e, x, settings, exception)=>{resolve(["Month", "Quote Enquiry", "Quotes", "Orders"]);},
                                success:function(data){
                                    resolve(data);
                                }
                            });
                        });
                    }
                    let jsonData=await getData();
                    var a = google.visualization.arrayToDataTable(jsonData),
                    b = {
                        chart: {
                        title: "",
                        subtitle: ""
                        },
                        bars: "vertical",
                        vAxis: {
                        format: "decimal"
                        },
                        height: 400,
                        width:'100%',
                        colors: ["#148df6", "#655af3", "#fd2e64", "#51bb25", "#ff5f24"]


                    },
                    c = new google.charts.Bar(document.getElementById("QuoteEnquiryBar"));
                    c.draw(a, google.charts.Bar.convertOptions(b))
                }
                const loadPaymentsBarBar=async()=>{
                    const getData=async()=>{
                        return new Promise(async(resolve,reject)=>{
                            $.ajax({
                                type:"post",
                                url:"{{route('admin.dashboard.get.payments.stats')}}",
                                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                                dataType:"json",
                                async:true,
                                error:(e, x, settings, exception)=>{resolve(["Month", "Receipts", "Payments"]);},
                                success:function(data){
                                    resolve(data);
                                }
                            });
                        });
                    }
                    let jsonData=await getData();
                    var a = google.visualization.arrayToDataTable(jsonData),
                    b = {
                        chart: {
                        title: "",
                        subtitle: ""
                        },
                        bars: "vertical",
                        vAxis: {
                        format: "decimal"
                        },
                        height: 400,
                        width:'100%',
                        colors: ["#ff5f24","#148df6", "#655af3", "#fd2e64", "#51bb25"]


                    },
                    c = new google.charts.Bar(document.getElementById("PaymentsBar"));
                    c.draw(a, google.charts.Bar.convertOptions(b))
                }
                loadQuoteEnquiryBar();
                loadPaymentsBarBar();
            }
            const loadCalendar=async()=>{
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    validRange:{
                        start:"{{date('Y-m-d',strtotime($FY->FromDate))}}",
                        end:"{{date('Y-m-d',strtotime($FY->ToDate))}}"
                    },
                    events:"{{route('admin.dashboard.get.upcoming.payments')}}",
                });
                calendar.render();
            }
            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.load('current', {'packages':['line']});
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(loadCharts);
            init();
        });
    </script>
@endsection