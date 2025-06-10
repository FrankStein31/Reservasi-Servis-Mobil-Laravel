@extends('layouts.app')
@section('title', 'Data Reservasi')
@section('content')

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Data Reservasi</h4>
                <div class="ml-auto d-flex">
                    <!-- Form Filter Tanggal -->
                    <form method="GET" action="{{ url('reservation') }}" class="form-inline mr-2">
                        <div class="input-group">
                            <input type="date" name="filter_date" class="form-control" value="{{ request('filter_date', date('Y-m-d')) }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-secondary"><i class="fa fa-filter"></i> Filter</button>
                                {{-- <a href="{{ url('reservation') }}" class="btn btn-warning"><i class="fa fa-times"></i> Reset</a> --}}
                            </div>
                        </div>
                    </form>

                    <!-- Tombol Cetak Rekap -->
                    <a href="{{ url('reservation/print?date=' . request('filter_date', date('Y-m-d'))) }}"
                       class="btn btn-info mr-2" target="_blank">
                        <i class="fa fa-print"></i> Cetak Rekap
                    </a>
                <a href="{{ url('reservation/create') }}" class="btn btn-primary ml-auto"><span
                    class="oi oi-plus"></span> Tambah </a>
                </div>
            </div>

        </div>
        <div class="card-body">

            @if (session('flash-success'))
            <div class="alert alert-success">
                {{ session('flash-success') }}
            </div>
        @endif
        @if (session('flash-danger'))
            <div class="alert alert-danger">
                {{ session('flash-danger') }}
            </div>
        @endif
        <!-- Tampilkan tanggal filter yang aktif -->
        @if(request('filter_date'))
        <div class="alert alert-info">
            Menampilkan data reservasi untuk tanggal: {{ date('d/m/Y', strtotime(request('filter_date'))) }}
            <a href="{{ url('reservation') }}" class="btn btn-sm btn-warning float-right">
                <i class="fa fa-times"></i> Hapus Filter
            </a>
        </div>
    @endif
            <div class="table-responsive">
                <table id="add-row" class="display table table-striped table-hover" >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Paket Layanan</th>
                            <th >Harga Paket</th>
                            <th >Kendaraan</th>
                            <th>Keluhan</th>
                            <th>Tanggal Reservasi</th>
                            <th>Jam Reservasi</th>
                            <th >Asal</th>
                            <th width="200%">Status Servis</th>
                            <th >Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservation as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->customer ? $item->customer->name : '?' }}</td>
                                <td>{{ $item->package ? $item->package->name : '?' }}</td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span>Rp</span>
                                        <span>{{ $item->package->products ? number_format($item->package->products->sum('price'), 0, ',', '.') : '' }}</span>
                                    </div>
                                </td>
                                <td>{!! $item->vehicle ? $item->vehicle->name . ' <br> <small><b>Nopol:</b> ' . $item->vehicle->plate_number . '</small>' : '?' !!}
                                </td>
                                <td>{{ $item->vehicle_complaint }}</td>
                                <td>{{ date('d/m/Y', strtotime($item->reservation_date)) }}
                                    @php
                                        // $start = date_create(date('Y-m-d'));
                                        // $end = date_create($item->reservation_date . ' ' . $item->reservation_time);
                                        // $diff = date_diff($start, $end);
                                        // echo '<pre>';
                                        // print_r($diff);
                                        // echo '</pre>';
                                    @endphp
                                    @if ($item->attendance_confirmation)
                                        <div class="small">
                                            <hr class="mb-1 mt-1">
                                            Konfirmasi kedatangan: @if ($item->attendance_confirmation == 'Not Present')
                                                <div class="text-danger">Tidak Jadi Datang</div>
                                                <small>{{ $item->attendance_message }}</small>
                                            @else:
                                                <div class="text-success">Jadi Datang</div>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td>{{ date('H:i', strtotime($item->reservation_time)) }}</td>
                                <td>{{ $item->reservation_origin == 'Online' ? 'Aplikasi' : 'Manual' }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @php
                                            if ($item->service->status == 'Process') {
                                                $badge = 'info';
                                            } elseif ($item->service->status == 'Finish') {
                                                $badge = 'success';
                                            } else {
                                                $badge = 'warning';
                                            }
                                        @endphp
                                        <span class="badge badge-pill badge-{{ $badge }}">&nbsp;</span>
                                        @if ($item->service->status == 'Finish')
                                            <span style="min-width: 50px" class="ml-2">Pembayaran Lunas</span>
                                        @else
                                            <form class="ml-2" style="min-width: 100px"
                                                action="{{ url('service/' . $item->service->id . '/status?ref=reservation') }}"
                                                method="POST">
                                                @csrf
                                                @method('put')
                                                <div>
                                                    <change-service-status :data="{{ $item->service }}" />
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                    @if ($item->service->mechanic)
                                        <div class="small mt-1">
                                            Montir: {{ $item->service->mechanic->name }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="form-button-action">
                                        <a title="Detail" data-toggle="tooltip"
                                        href="{{ url('reservation/' . $item->id) }}"
                                        class="btn btn-sm btn-success"><i class="fa fa-search"></i></a>
                                    @if ($item->service->payment)
                                        <a title="Pembayaran" data-toggle="tooltip"
                                            href="{{ url('payment/' . $item->service->payment->id . '?reservation_id=' . $item->id) }}"
                                            class="btn btn-sm btn-danger"><i class="fa fa-credit-card"></i></a>
                                    @endif

                                    </div>

                                    {{-- <a href="{{ url('reservation/' . $item->id . '/edit') }}"
                                            class="btn btn-sm btn-info">Ubah</a> --}}
                                    {{-- <form action="{{ url('reservation/' . $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button onclick="return confirm('Apakah anda yakin?')"
                                                class="btn btn-sm btn-danger">Hapus</button>
                                        </form> --}}
                                </td>
                            </tr>
                        @endforeach
                        @if (count($reservation) < 1)
                            <tr>
                                <td colspan="11" class="text-center">Data kosong.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="mt-3 d-flex justify-content-end">
                {{ $reservation->links() }}
            </div>
        </div>
    </div>
</div>
@push('script')
<script >
    $(document).ready(function() {

        // Add Row
        $('#add-row').DataTable({
            "pageLength": 5,       });

    });
</script>
@endpush
@endsection
