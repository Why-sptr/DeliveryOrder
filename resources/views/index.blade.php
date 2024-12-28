@extends('layouts.app')

@section('content')
<section class="section dashboard">
    <div class="row">
        <!-- Left side columns -->
        <div class="col">
            <div class="row">
                <div class="col-12">
                    <div class="card p-3 d-flex">
                        <i class="bi bi-hand-wave me-2"></i>
                        <h4>Hello, welcome back <span class="fw-bold">{{ auth()->user()->name }}</span> 👋!</h4>
                    </div>
                </div>

                <!-- Sales Card -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card reservation">

                        <div class="card-body">
                            <h5 class="card-title">Reservation <span>| Count</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-book"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$reservation}}</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card idbadge">

                        <div class="card-body">
                            <h5 class="card-title">ID Badges <span>| Count</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-bookmark-check"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$idBadge}}</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->

                <!-- Customers Card -->
                <div class="col-xxl-3 col-md-6">

                    <div class="card info-card user">

                        <div class="card-body">
                            <h5 class="card-title">Users <span>| Count</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$user}}</h6>
                                </div>
                            </div>

                        </div>
                    </div>

                </div><!-- End Customers Card -->
                <div class="col-xxl-3 col-md-6">

                    <div class="card info-card admin">

                        <div class="card-body">
                            <h5 class="card-title">Admins <span>| Count</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$admin}}</h6>
                                </div>
                            </div>

                        </div>
                    </div>

                </div><!-- End Customers Card -->

                <!-- Reports -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Reservation <span>Chart</span></h5>

                            <!-- Line Chart -->
                            <div id="reportsChart"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    const chartData = @json($chartData);
                                    new ApexCharts(document.querySelector("#reportsChart"), {
                                        series: [{
                                            name: 'Reservation',
                                            data: chartData.counts,
                                        }],
                                        chart: {
                                            height: 350,
                                            type: 'area',
                                            toolbar: {
                                                show: false
                                            },
                                        },
                                        markers: {
                                            size: 4
                                        },
                                        colors: ['#4154f1'],
                                        fill: {
                                            type: "gradient",
                                            gradient: {
                                                shadeIntensity: 1,
                                                opacityFrom: 0.3,
                                                opacityTo: 0.4,
                                                stops: [0, 90, 100]
                                            }
                                        },
                                        dataLabels: {
                                            enabled: false
                                        },
                                        stroke: {
                                            curve: 'smooth',
                                            width: 2
                                        },
                                        xaxis: {
                                            type: 'datetime',
                                            categories: chartData.dates
                                        },
                                        tooltip: {
                                            x: {
                                                format: 'dd/MM/yy'
                                            },
                                        }
                                    }).render();
                                });
                            </script>
                            <!-- End Line Chart -->

                        </div>
                    </div>
                </div>
                <!-- End Reports -->

                <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">

                        <div class="card-body">
                            <h5 class="card-title">Recent Reservation <span>| Latest</span></h5>

                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Reservation/PO</th>
                                        <th scope="col">Date Reservation</th>
                                        <th scope="col">Item</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">ID Badges</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservations as $reservation)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{$reservation->user->name}}</td>
                                        <td>{{$reservation->no_reservation}}</td>
                                        <td>{{$reservation->reservation_date}}</td>
                                        <td>{{$reservation->item}}</td>
                                        <td>{{$reservation->quantity}}</td>
                                        <td>@foreach($reservation->user->idBadges as $badge)
                                            <span class="badge bg-info">{{ $badge->badge_name }}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div><!-- End Recent Sales -->

            </div>
        </div><!-- End Left side columns -->

    </div>
</section>
@endsection