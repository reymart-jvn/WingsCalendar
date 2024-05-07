@extends('layouts.star-admin-app')
@section('css')
    <style>
        /* #barChart {
                    height: 580px !important;
                } */
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-center justify-content-between border-bottom">

                    </div>
                    <div class="tab-content tab-content-basic">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                            <div class="row">
                                <div class="col-lg-3 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                            <div class="card card-gradient">
                                                <div class="card-body">
                                                    <div class="circle-shadow-primary">
                                                        <i class="mdi mdi-chart-line" style="height:200px;width:200px"></i>
                                                    </div>
                                                    <h6>Total Sales</h6>
                                                    <p>+50% Income</p>
                                                    <h5 class="text-primary">$668 m</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                            <div class="card card-gradient">
                                                <div class="card-body">
                                                    <div class="circle-shadow-success">
                                                        <i class="mdi mdi-arrow-down-bold-hexagon-outline"></i>
                                                    </div>
                                                    <h6>Daily Sales</h6>
                                                    <p>Daily Sales</p>
                                                    <h5 class="text-success">$434 k</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                            <div class="card card-gradient">
                                                <div class="card-body">
                                                    <div class="circle-shadow-info">
                                                        <i class="mdi mdi-account-outline"></i>
                                                    </div>
                                                    <h6>Daily User</h6>
                                                    <p>+32% New User</p>
                                                    <h5 class="text-info">$278 m</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                            <div class="card card-gradient">
                                                <div class="card-body">
                                                    <div class="circle-shadow-danger">
                                                        <i class="mdi mdi-cube-outline"></i>
                                                    </div>
                                                    <h6>Products</h6>
                                                    <p>+80% New Products</p>
                                                    <h5 class="text-danger">658</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-5 grid-margin grid-margin-lg-0 stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title card-title-dash">Employees by Department</h4>
                                            <div class="pt-3">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="chartjs-size-monitor">
                                                            <div class="chartjs-size-monitor-expand">
                                                                <div class=""></div>
                                                            </div>
                                                            <div class="chartjs-size-monitor-shrink">
                                                                <div class=""></div>
                                                            </div>
                                                        </div>
                                                        <canvas class="my-auto chartjs-render-monitor" id="doughnutChart"
                                                            height="160" width="217"
                                                            style="display: block; width: 217px; height: 144px;"></canvas>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="row doughnut-hr-legend mb-4">
                                                            <div class="col-6">
                                                                <p class="legend-value">
                                                                    50
                                                                </p>
                                                                <p class="legend-label align-items-center d-flex">
                                                                    <span class="bg-primary me-2"></span>Developers
                                                                </p>
                                                            </div>
                                                            <div class="col-6">
                                                                <p class="legend-value">
                                                                    20
                                                                </p>
                                                                <p class="legend-label align-items-center d-flex">
                                                                    <span class="bg-secondary me-2"></span>Marketing
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row doughnut-hr-legend">
                                                            <div class="col-6">
                                                                <p class="legend-value">
                                                                    20
                                                                </p>
                                                                <p class="legend-label align-items-center d-flex">
                                                                    <span class="bg-danger me-2"></span>Finance
                                                                </p>
                                                            </div>
                                                            <div class="col-6">
                                                                <p class="legend-value">
                                                                    10
                                                                </p>
                                                                <p class="legend-label align-items-center d-flex">
                                                                    <span class="bg-info me-2"></span>Designing
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7 grid-margin grid-margin-lg-0 stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div>
                                            <h4 class="card-title">Bar chart</h4>
                                            <canvas id="barChart" width="463" height="130"
                                                style="display: block; width: 463px; height: 300px;"
                                                class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row flex-grow">
                                <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                    <div class="card card-rounded">
                                        <div class="card-body">
                                            <div class="d-sm-flex justify-content-between align-items-start">
                                                <div>
                                                    <h4 class="card-title card-title-dash">Performance Line Chart</h4>
                                                    <h5 class="card-subtitle card-subtitle-dash">Lorem Ipsum is simply
                                                        dummy text of the printing</h5>
                                                </div>
                                                <div id="performance-line-legend">
                                                    <div class="chartjs-legend">
                                                        <ul>
                                                            <li><span style="background-color:#1F3BB3"></span>This week
                                                            </li>
                                                            <li><span style="background-color:#52CDFF"></span>Last week
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="chartjs-wrapper mt-4">
                                                <div class="chartjs-size-monitor">
                                                    <div class="chartjs-size-monitor-expand">
                                                        <div class=""></div>
                                                    </div>
                                                    <div class="chartjs-size-monitor-shrink">
                                                        <div class=""></div>
                                                    </div>
                                                </div>
                                                <canvas id="performaneLine"
                                                    style="display: block; width: 643px; height: 150px;" width="643"
                                                    height="150" class="chartjs-render-monitor"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
