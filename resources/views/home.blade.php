@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<h4 class="mb-4">Selamat datang, {{ Auth::user()->name }}!</h4>
<div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp stamp-md bg-secondary mr-3">
                    <i class="fa fa-dollar-sign"></i>
                </span>
                <div>
                    <h5 class="mb-1">Total Paket Layanan</h5>
                    <h5 class="text-muted"><b><a href="#">{{ $tot_paket }}</small></a></b></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp stamp-md bg-success mr-3">
                    <i class="fa fa-shopping-cart"></i>
                </span>
                <div>
                    <h5 class="mb-1">Total Customer</h5>
                    <h5 class="text-muted"><b><a href="#">{{ $tot_customer }}</small></a></b></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp stamp-md bg-danger mr-3">
                    <i class="fa fa-users"></i>
                </span>
                <div>
                    <h5 class="mb-1">Total Pendapatan</h5>
                    <h5 class="text-muted"><b><a href="#">{{ number_format($tot_pendapatan, 0, ',', '.') }}</small></a></b></h5>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-sm-6 col-lg-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp stamp-md bg-warning mr-3">
                    <i class="fa fa-comment-alt"></i>
                </span>
                <div>
                    <h5 class="mb-1"><b><a href="#">132 <small>Comments</small></a></b></h5>
                    <small class="text-muted">16 waiting</small>
                </div>
            </div>
        </div>
    </div> -->
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <form action="" method="GET" class="w-100">
                        @csrf
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <h5 class="mb-3 mb-md-0">Statistik</h5>
                            <div class="d-flex flex-wrap w-90 gap-3"> <!-- Increased gap to 3 -->
                                <div class="flex-grow-1 me-2" style="min-width: 150px;"> <!-- Added right margin -->
                                    <select name="bulan" class="form-control form-control-sm">
                                        @foreach ($months as $item)
                                            <option value="{{ $item->number }}" {{ $bulan_filter == $item->number ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex-grow-1 me-2" style="min-width: 150px;"> <!-- Added right margin -->
                                    <select name="tahun" class="form-control form-control-sm">
                                        @foreach ($years as $item)
                                            <option value="{{ $item->year }}" {{ $tahun_filter == $item->year ? 'selected' : '' }}>
                                                {{ $item->year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="ms-md-auto"> <!-- Added left margin on medium screens -->
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body">
                <div class="chart-container mb-4" style="min-height: 375px">
                    <canvas id="statistik"></canvas>
                </div>


            </div>

            {{--
            <div class="card-tools">
                <a href="#" class="btn btn-info btn-border btn-round btn-sm mr-2">
                    <span class="btn-label">
                        <i class="fa fa-pencil"></i>
                    </span>
                    Export
                </a>
                <a href="#" class="btn btn-info btn-border btn-round btn-sm">
                    <span class="btn-label">
                        <i class="fa fa-print"></i>
                    </span>
                    Print
                </a>
            </div>
            --}}
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-gradient text-black">
            <div class="card-header">
                <div class="card-title text-black">Daily Sales</div>
            </div>
            <div class="card-body pb-0">
                <div class="pull-in">
                    <canvas id="dailySalesChart"></canvas>
                </div>
                <div class="mb-4 mt-2">
                    <h1 class="text-black">Rp {{ number_format($totalSalesToday ?? 0, 0, ',', '.') }}</h1>
                </div>
            </div>
        </div>

        <div class="card card-primary bg-primary-gradient w-100" style="height: 170px;">
            <div class="card-body">
                <h4 class="mb-1 fw-bold">Reservasi Belum Selesai Hari Ini</h4>
                <div id="task-complete" class="chart-circle mt-4 mb-3"></div>
            </div>
        </div>

    </div>
</div>




@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // --- CHART BULANAN (Reservasi & Servis) ---
        var bulan = <?= $bulan ?>;
        var reservasi = <?= $reservasi ?>;
        var servis = <?= $servis ?>;

        var statistikCtx = document.getElementById('statistik').getContext('2d');
        new Chart(statistikCtx, {
            type: 'line',
            data: {
                labels: bulan,
                datasets: [
                    {
                        label: 'Total Reservasi',
                        backgroundColor: 'rgba(26, 187, 156, 0.4)',
                        borderColor: 'rgba(26, 187, 156, 0.7)',
                        hoverBackgroundColor: 'rgba(26, 187, 156, 0.6)',
                        hoverBorderColor: 'rgba(26, 187, 156, 1)',
                        tension: 0.2,
                        fill: true,
                        data: reservasi
                    },
                    {
                        label: 'Total Servis',
                        backgroundColor: 'rgba(255, 99, 132, 0.4)',
                        borderColor: 'rgba(255, 99, 132, 0.7)',
                        hoverBackgroundColor: 'rgba(255, 99, 132, 0.6)',
                        hoverBorderColor: 'rgba(255, 99, 132, 1)',
                        tension: 0.2,
                        fill: true,
                        data: servis
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctx = document.getElementById('dailySalesChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! $labels !!},
        datasets: [{
            label: 'Penjualan (Rp)',
            data: {!! $salesData !!},
            fill: true,
            borderColor: 'black',
            backgroundColor: 'white',
            tension: 0.3,
            pointBackgroundColor: 'rgba(255,255,255,1)',
            pointBorderColor: 'rgb(0,0,0)',
            borderWidth: 2,
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    color: 'green',
                    font: {
                        size: 20
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: 'white',
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                },
                grid: {
                    color: 'rgba(255,255,255,0.1)'
                },
                border: {
                    color: '#fff'
                }
            },
            x: {
                ticks: {
                    color: 'white'
                },
                grid: {
                    color: 'rgba(255,255,255,0.1)'
                },
                border: {
                    color: 'white'
                }
            }
        }
    }
});
var circle = Circles.create({
        id: 'task-complete',
        radius: 40,
        value: {{ $progress_process ?? 0 }},
        maxValue: 100,
        width: 10,
        text: function (value) { return value + '%' },
        colors: ['#ffcccb', '#ffffff'], // contoh: merah muda sebagai warna belum selesai
        duration: 400,
        wrpClass: 'circles-wrp',
        textClass: 'circles-text',
        styleWrapper: true,
        styleText: true
    });
// const myChart = new Chart(dailySalesCtx, {
//   type: "bar",
//   data: {
//     labels: ["label 1", "label 2"],
//     datasets: [{
//       label: "My Label",
//       backgroundColor: "rgba(159,170,174,0.8)",
//       borderWidth: 1,
//       hoverBackgroundColor: "rgba(232,105,90,0.8)",
//       hoverBorderColor: "orange",
//       scaleStepWidth: 1,
//       data: [4, 5],
//       color: '#233333'
//     }]
//   },
//   options: {
//     plugins: {  // 'legend' now within object 'plugins {}'
//       legend: {
//         labels: {
//           color: "blue",  // not 'fontColor:' anymore
//           // fontSize: 18  // not 'fontSize:' anymore
//           font: {
//             size: 18 // 'size' now within object 'font {}'
//           }
//         }
//       }
//     },
//     scales: {
//       y: {  // not 'yAxes: [{' anymore (not an array anymore)
//         ticks: {
//           color: "green", // not 'fontColor:' anymore
//           // fontSize: 18,
//           font: {
//             size: 18, // 'size' now within object 'font {}'
//           },
//           stepSize: 1,
//           beginAtZero: true
//         }
//       },
//       x: {  // not 'xAxes: [{' anymore (not an array anymore)
//         ticks: {
//           color: "purple",  // not 'fontColor:' anymore
//           //fontSize: 14,
//           font: {
//             size: 14 // 'size' now within object 'font {}'
//           },
//           stepSize: 1,
//           beginAtZero: true
//         }
//       }
//     }
//   }
// });
// console.log();

    });
</script>


@endpush
