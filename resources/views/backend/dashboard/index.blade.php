@extends('layouts.backend.main')
@section('title', 'Dashboard')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">@yield('title')</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card crm-widget">
                <div class="card-body p-0">
                    <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                        <div class="col-xxl-6 col-md-6">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Pengguna</h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-account-group display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value"
                                                data-target="{{ $countUser }}">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->


                        <div class="col-xxl-6 col-md-6">
                            <div class="mt-3 mt-lg-0 py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Pelanggan</h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-account display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value"
                                                data-target="{{ $countCustomer }}">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Status Pelanggan</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="customer_status_chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div><!-- end card -->
            <!-- end col -->
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var options = {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'Jumlah',
                data: [{{ $countLoyalCustomer }}, {{ $countNewCustomer }}]
            }],
            colors: ['#00E396', '#FEB019'],
            plotOptions: {
                bar: {
                    distributed: true
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return val;
                }
            },
            xaxis: {
                categories: ['Loyal Customer', 'New Customer']
            },
            legend: {
                show: false
            }
        };

        var chart = new ApexCharts(document.querySelector("#customer_status_chart"), options);
        chart.render();
    </script>
@endsection
