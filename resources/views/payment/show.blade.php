@extends('layouts.app')
@section('title', 'Input Pembayaran')
@section('content')

    {{-- Halaman Normal yang Ditampilkan --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body" id="app">
                        <h2>Detail Pembayaran / #{{ $payment->id }}</h2>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Pelanggan</label>
                                <div class="h5">{{ $payment->service->reservation->customer->name }}</div>
                                <div class="small">No. HP/Telp:
                                    {{ $payment->service->reservation->customer->phone ?? '-' }}</div>
                                <div class="small">Alamat: {{ $payment->service->reservation->customer->address ?? '-' }}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Kendaraan</label>
                                <div class="h5">{{ $payment->service->reservation->vehicle->name }}</div>
                                <div class="small">Nopol: {{ $payment->service->reservation->vehicle->plate_number }}
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="h6">ID Servis: #
                                    {{ str_pad($payment->service->id, 5, '0', STR_PAD_LEFT) }}</div>
                                <div class="h6">Tgl. Servis:
                                    {{ date('d/m/Y', strtotime($payment->service->service_date)) }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="h6">ID Pembayaran: #
                                    {{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</div>
                                <div class="h6">Tgl. Bayar:
                                    {{ date('d/m/Y', strtotime($payment->created_at)) }}</div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th>Tagihan Servis</th>
                                            <th width="10">:</th>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <span>Rp</span>
                                                    <div class="h3">
                                                        {{ number_format($payment->bill, 0, ',', '.') }}</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Pembayaran Pelanggan</th>
                                            <th width="10">:</th>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <span>Rp</span>
                                                    <span> {{ number_format($payment->pay, 0, ',', '.') }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Kembalian</th>
                                            <th width="10">:</th>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <span>Rp</span>
                                                    <span> {{ number_format($payment->change, 0, ',', '.') }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            @if (request()->query('reservation_id'))
                                <a href="{{ url('reservation/' . request()->query('reservation_id')) }}"
                                    class="btn btn-secondary">Kembali</a>
                            @else
                                <a href="{{ url('payment') }}" class="btn btn-secondary">Kembali</a>
                            @endif
                            <button class="btn btn-primary" id="btnPrint">
                                <i class="fas fa-print"></i> Cetak Nota
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Template untuk Dicetak (tersembunyi) --}}
    <div id="printSection" style="display: none;">
        <div class="print-container" style="width: 100%; max-width: 800px; margin: 0 auto; font-family: Arial, sans-serif;">
            <div style="text-align: center; margin-bottom: 20px;">
                <h2 style="margin-bottom: 5px;">NOTA PEMBAYARAN</h2>
                <p style="margin: 5px 0;">BENGKEL MOTOR CAK DHI</p>
                <p style="margin: 5px 0;">
                    Jl. Raya Kandangan Dusun Katerban No.03/02, Katreban, Pulorejo, Kec. Ngoro, Kabupaten Jombang<br>
                    Telp: 082334942493
                </p>
                <p style="margin: 5px 0;">No. Pembayaran: #{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p style="margin: 5px 0;">Tanggal: {{ date('d/m/Y H:i', strtotime($payment->created_at)) }}</p>
            </div>

            <hr style="border-top: 1px solid #ddd; margin: 15px 0;">

            <div style="overflow: hidden; margin-bottom: 15px;">
                <div style="float: left; width: 48%;">
                    <p style="font-weight: bold; margin-bottom: 5px;">Pelanggan</p>
                    <p style="margin: 5px 0;"><strong>{{ $payment->service->reservation->customer->name }}</strong></p>
                    <p style="margin: 5px 0; font-size: 14px;">No. HP/Telp: {{ $payment->service->reservation->customer->phone ?? '-' }}</p>
                    <p style="margin: 5px 0; font-size: 14px;">Alamat: {{ $payment->service->reservation->customer->address ?? '-' }}</p>
                </div>
                <div style="float: right; width: 48%;">
                    <p style="font-weight: bold; margin-bottom: 5px;">Kendaraan</p>
                    <p style="margin: 5px 0;"><strong>{{ $payment->service->reservation->vehicle->name }}</strong></p>
                    <p style="margin: 5px 0; font-size: 14px;">Nopol: {{ $payment->service->reservation->vehicle->plate_number }}</p>
                </div>
            </div>

            <hr style="border-top: 1px solid #ddd; margin: 15px 0;">

            <div style="overflow: hidden; margin-bottom: 15px;">
                <div style="float: left; width: 48%;">
                    <p style="margin: 5px 0;">ID Servis: #{{ str_pad($payment->service->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p style="margin: 5px 0;">Tgl. Servis: {{ date('d/m/Y', strtotime($payment->service->service_date)) }}</p>
                </div>
                <div style="float: right; width: 48%;">
                    <p style="margin: 5px 0;">ID Pembayaran: #{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p style="margin: 5px 0;">Tgl. Bayar: {{ date('d/m/Y', strtotime($payment->created_at)) }}</p>
                </div>
            </div>

            <hr style="border-top: 1px solid #ddd; margin: 15px 0;">

            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                    <td style="padding: 8px 0; width: 50%;"><strong>Tagihan Servis</strong></td>
                    <td style="padding: 8px 0; width: 5%;">:</td>
                    <td style="padding: 8px 0; text-align: right;">
                        <span>Rp</span>
                        <span style="font-size: 20px; font-weight: bold;">{{ number_format($payment->bill, 0, ',', '.') }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0;"><strong>Pembayaran Pelanggan</strong></td>
                    <td style="padding: 8px 0;">:</td>
                    <td style="padding: 8px 0; text-align: right;">
                        <span>Rp</span>
                        <span>{{ number_format($payment->pay, 0, ',', '.') }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0;"><strong>Kembalian</strong></td>
                    <td style="padding: 8px 0;">:</td>
                    <td style="padding: 8px 0; text-align: right;">
                        <span>Rp</span>
                        <span>{{ number_format($payment->change, 0, ',', '.') }}</span>
                    </td>
                </tr>
            </table>

            <div style="text-align: center; margin-top: 40px;">
                <p style="margin: 5px 0;">Terima kasih atas kepercayaan Anda</p>
                <p style="margin: 5px 0;">Silahkan datang kembali</p>
            </div>
        </div>
    </div>

    <style>
        @media print {
            /* Sembunyikan semua elemen */
            body * {
                visibility: hidden;
                display: none;
            }

            /* Reset untuk kontainer cetak */
            body, html {
                margin: 0;
                padding: 0;
                background-color: white;
                width: 100%;
                height: auto;
            }

            /* Tampilkan hanya bagian yang ingin dicetak */
            #printSection, #printSection * {
                visibility: visible !important;
                display: block !important;
            }

            /* Posisikan printSection agar mengisi seluruh halaman cetak */
            #printSection {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                padding: 20px !important;
                margin: 0 !important;
                background-color: white !important;
            }

            /* Hapus semua bayangan dan border */
            #printSection .card,
            #printSection .card-body {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            /* Sembunyikan elemen UI yang tidak perlu */
            .navbar,
            .footer,
            #app nav,
            #btnPrint,
            .btn,
            .sidebar,
            .main-header,
            .main-sidebar {
                display: none !important;
                visibility: hidden !important;
            }
        }
    </style>

    <script>
        // Fungsi untuk mencetak hanya bagian tertentu
        function printNota() {
            // Simpan state sebelumnya
            const originalContents = document.body.innerHTML;

            // Ambil isi dari printSection
            const printContents = document.getElementById('printSection').innerHTML;

            // Ganti isi body dengan konten yang akan dicetak
            document.body.innerHTML = '<div id="printOnly">' + printContents + '</div>';

            // Trigger print dialog
            window.print();

            // Pulihkan body ke keadaan semula
            document.body.innerHTML = originalContents;

            // Rebind event listeners karena DOM telah diganti
            setupPrintHandlers();

            return true;
        }

        // Setup event listeners
        function setupPrintHandlers() {
            document.addEventListener("DOMContentLoaded", function() {
                // Cek apakah elemen btnPrint ada
                var btnPrint = document.getElementById('btnPrint');
                if (btnPrint) {
                    btnPrint.addEventListener('click', function(e) {
                        e.preventDefault();
                        printNota();
                    });
                } else {
                    console.error("Tombol print tidak ditemukan!");
                }
            });

            // Cara alternatif jika jQuery tersedia di aplikasi Anda
            if (typeof jQuery !== 'undefined') {
                jQuery(document).ready(function($) {
                    $("#btnPrint").on('click', function(e) {
                        e.preventDefault();
                        printNota();
                    });
                });
            }
        }

        // Initialize
        setupPrintHandlers();

        // Jika DOM sudah siap, langsung setup handler
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            setupPrintHandlers();
        }
    </script>

@endsection