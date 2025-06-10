<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Pendapatan - {{ date('d-m-Y', strtotime($date)) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            font-size: 12px;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .summary {
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
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
    <div class="report-title">REKAP PENDAPATAN TANGGAL: {{ date('d/m/Y', strtotime($date)) }}</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Servis</th>
                <th>Tagihan</th>
                <th>Pembayaran</th>
                <th>Kembalian</th>
                <th>Penanggung Jawab</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>#{{ $item->service->id }}</td>
                    <td>Rp {{ number_format($item->bill, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->pay, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->change, 0, ',', '.') }}</td>
                    <td>{{ $item->admin->name }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        Total Pendapatan: Rp {{ number_format($totalIncome, 0, ',', '.') }}
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
        <p>Dicetak oleh: {{ auth()->user()->name }}</p>
        <br><br>
        <p>(_______________________)</p>
        <p>Manager</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</body>
</html>
