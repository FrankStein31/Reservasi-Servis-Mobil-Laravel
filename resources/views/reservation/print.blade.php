<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Reservasi - {{ date('d-m-Y', strtotime($date)) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .company-address {
            font-size: 12px;
            margin-bottom: 5px;
        }
        .report-title {
            font-size: 16px;
            font-weight: bold;
            margin: 15px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .summary {
            margin-top: 20px;
            font-weight: bold;
        }
        .status-box {
            display: inline-block;
            width: 10px;
            height: 10px;
            margin-right: 5px;
        }
        .status-waiting {
            background-color: #ffc107;
        }
        .status-process {
            background-color: #17a2b8;
        }
        .status-finish {
            background-color: #28a745;
        }
        .status-selesai {
            background-color: #ff04b4;
        }
        .status-legend {
            margin-top: 10px;
            font-size: 11px;
        }
        @media print {
            @page {
                size: landscape;
            }
            body {
                padding: 0;
                margin: 1cm;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">BENGKEL MOTOR CAK DHI</div>
        <div class="company-address">Jl. Raya Kandangan Dusun Katerban No.03/02, Katreban, Pulorejo, Kec. Ngoro, Kabupaten Jombang</div>
        <div class="company-address">Telp: 082334942493 </div>
    </div>

    <div class="report-title">REKAP RESERVASI TANGGAL: {{ date('d/m/Y', strtotime($date)) }}</div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Paket Layanan</th>
                <th>Kendaraan</th>
                <th>Keluhan</th>
                <th>Jam Reservasi</th>
                <th>Status</th>
                <th>Montir</th>
                <th>Harga Paket</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
                $countWaiting = 0;
                $countProcess = 0;
                $countFinish = 0;
                $countSelesai = 0;
            @endphp

            @foreach ($reservations as $index => $item)
                @php
                    $price = $item->package->products ? $item->package->products->sum('price') : 0;
                    $total += $price;

                    if ($item->service->status == 'Pending') {
                        $countWaiting++;
                    } elseif ($item->service->status == 'Process') {
                        $countProcess++;
                    } elseif ($item->service->status == 'Finish') {
                        $countFinish++;
                    }elseif ($item->service->status == 'Selesai') {
                        $countSelesai++;
                    }
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->customer ? $item->customer->name : '-' }}</td>
                    <td>{{ $item->package ? $item->package->name : '-' }}</td>
                    <td>{{ $item->vehicle ? $item->vehicle->name . ' (' . $item->vehicle->plate_number . ')' : '-' }}</td>
                    <td>{{ $item->vehicle_complaint }}</td>
                    <td>{{ date('H:i', strtotime($item->reservation_time)) }}</td>
                    <td>
                        @php
                            if ($item->service->status == 'Process') {
                                $statusClass = 'status-process';
                                $statusText = 'Proses';
                            } elseif ($item->service->status == 'Selesai') {
                                $statusClass = 'status-selesai';
                                $statusText = 'Selesai Servis';
                            } elseif ($item->service->status == 'Finish') {
                                $statusClass = 'status-finish';
                                $statusText = 'Pembayaran Selesai';
                            }else {
                                $statusClass = 'status-waiting';
                                $statusText = 'Menunggu';
                            }
                        @endphp
                        <span class="status-box {{ $statusClass }}"></span> {{ $statusText }}
                    </td>
                    <td>{{ $item->service->mechanic ? $item->service->mechanic->name : '-' }}</td>
                    <td>Rp {{ number_format($price, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            @if (count($reservations) < 1)
                <tr>
                    <td colspan="9" style="text-align: center;">Tidak ada data reservasi untuk tanggal ini.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="summary">
        <p>Jumlah Reservasi: {{ count($reservations) }}</p>
        <p>Total Nilai Reservasi: Rp {{ number_format($total, 0, ',', '.') }}</p>
    </div>

    <div class="status-legend">
        Status:
        <span class="status-box status-waiting"></span> Menunggu ({{ $countWaiting }}) |
        <span class="status-box status-process"></span> Proses ({{ $countProcess }}) |
        <span class="status-box status-selesai"></span> Servis Selesai ({{ $countSelesai }}) |
        <span class="status-box status-finish"></span> Pembayaran Selesai ({{ $countFinish }})
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
        <p>Oleh: {{ auth()->user()->name }}</p>
        <br><br>
        <p>( ________________________ )</p>
        <p>Manager</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>