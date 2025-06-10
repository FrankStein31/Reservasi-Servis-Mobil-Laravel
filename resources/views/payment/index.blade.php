@extends('layouts.app')
@section('title', 'Data Pembayaran')
@section('content')

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Data Pembayaran</h4>
                <div class="ml-auto d-flex">
                <form method="GET" action="{{ url('payment') }}" class="form-inline mr-2">
                    <div class="input-group">
                        <input type="date" name="filter_date" class="form-control" value="{{ request('filter_date', date('Y-m-d')) }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary"><i class="fa fa-filter"></i> Filter</button>
                            {{-- <a href="{{ url('reservation') }}" class="btn btn-warning"><i class="fa fa-times"></i> Reset</a> --}}
                        </div>
                    </div>
                </form>
                <a href="{{ url('payment/print?date=' . request('filter_date', date('Y-m-d'))) }}"
                   class="btn btn-info mr-2" target="_blank">
                    <i class="fa fa-print"></i> Cetak Rekap
                </a>

                <a href="{{ url('payment') }}" class="btn btn-primary ml-auto"><span
                    class="oi oi-plus"></span> Lihat Reservasi </a>
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
        @if(request('filter_date'))
        <div class="alert alert-info">
            Menampilkan data pembayaran untuk tanggal: {{ date('d/m/Y', strtotime(request('filter_date'))) }}
            <a href="{{ url('payment') }}" class="btn btn-sm btn-warning float-right">
                <i class="fa fa-times"></i> Hapus Filter
            </a>
        </div>
    @endif
            <div class="table-responsive">
                <table id="add-row" class="display table table-striped table-hover" >
                    <thead>
                        <tr>
                            <th>No</th>
                                        <th>ID Servis</th>
                                        <th>Tagihan</th>
                                        <th>Pembayaran</th>
                                        <th>Kembalian</th>
                                        <th>Penanggungjawab</th>
                                        <th>Tanggal</th>
                                        <th width="15%">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td># {{ $item->service->id }}</td>
                                <td>{{ $item->bill }}</td>
                                <td>{{ $item->pay }}</td>
                                <td>{{ $item->change }}</td>
                                <td>{{ $item->admin->name }}</td>
                                <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                <td>
                                    <a href="{{ url('payment/' . $item->id) }}"
                                        class="btn btn-sm btn-success">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                        @if (count($payments) < 1)
                            <tr>
                                <td colspan="8" class="text-center">Data kosong.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="mt-3 d-flex justify-content-end">
                {{ $payments->links() }}
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
