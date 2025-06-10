<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Package;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
{
    $today = Carbon::today();
    $data['totalSalesToday'] = Payment::whereDate('created_at', $today)->sum('bill');

    // Filter bulan dan tahun
    $bulan_filter = $request->has('bulan') ?  $request->bulan : date("m");
    $tahun_filter = $request->has('tahun') ? $request->tahun : date("Y");
    $data['bulan_filter'] = $bulan_filter;
    $data['tahun_filter'] = $tahun_filter;

    // Daftar bulan
    $list_bulan = DB::table('months')->get();

    // Reservasi
    $query_r = DB::table('reservations')
        ->selectRaw('months.number as number, months.name as month, count(reservations.id) as total')
        ->leftJoin('months', 'months.number', '=', DB::raw("MONTH(reservations.reservation_date)"));

    if (!empty($bulan_filter)) {
        $query_r = $query_r->whereMonth('reservation_date', $bulan_filter);
    }
    if (!empty($tahun_filter)) {
        $query_r = $query_r->whereYear('reservation_date', $tahun_filter);
    }
    $dt_reservasi = $query_r->groupByRaw('month')->get();

    $dt_r = [];
    foreach ($dt_reservasi as $value) {
        $no =  $value->number;
        $dt_r['reservasi'][$no] = $value->total;
    }

    // Servis
    $query_r = DB::table('services')
        ->selectRaw('months.number as number, months.name as month, count(services.id) as total')
        ->leftJoin('months', 'months.number', '=', DB::raw("MONTH(services.service_date)"));

    if (!empty($bulan_filter)) {
        $query_r = $query_r->whereMonth('service_date', $bulan_filter);
    }
    if (!empty($tahun_filter)) {
        $query_r = $query_r->whereYear('service_date', $tahun_filter);
    }
    $dt_service = $query_r->groupByRaw('month')->get();

    $dt_s = [];
    foreach ($dt_service as $value) {
        $no =  $value->number;
        $dt_s['servis'][$no] = $value->total;
    }

    // Gabungkan data reservasi dan servis per bulan
    foreach ($list_bulan as $b) {
        $no = $b->number;
        if (isset($dt_r['reservasi'][$no]) && isset($dt_s['servis'][$no])) {
            $data['reservasi'][] = $dt_r['reservasi'][$no];
            $data['servis'][] = $dt_s['servis'][$no];
        } elseif (isset($dt_r['reservasi'][$no]) && !isset($dt_s['servis'][$no])) {
            $data['reservasi'][] = $dt_r['reservasi'][$no];
            $data['servis'][] = 0;
        } elseif (!isset($dt_r['reservasi'][$no]) && isset($dt_s['servis'][$no])) {
            $data['reservasi'][] = 0;
            $data['servis'][] = $dt_s['servis'][$no];
        } else {
            $data['reservasi'][] = 0;
            $data['servis'][] = 0;
        }
        $data['bulan'][] = $b->name;
    }

    // Total paket dan customer
    $data['months'] = $list_bulan;
    $data['years'] = DB::table('reservations')->selectRaw('YEAR(reservation_date) as year')->groupBy('year')->get();
    $data['bulan'] = json_encode($data['bulan']);
    $data['reservasi'] = json_encode($data['reservasi']);
    $data['servis'] = json_encode($data['servis']);

    $data['tot_paket'] = Package::count();
    $data['tot_customer'] = Customer::count();
    $pendapatan = Payment::selectRaw('SUM(bill) as total')->first();
    $data['tot_pendapatan'] = $pendapatan ? $pendapatan->total : 0;

    // Tambahan: Data 7 Hari Terakhir untuk Chart Penjualan
    $labels = [];
    $salesData = [];

    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::today()->subDays($i);
        $labels[] = $date->format('d M'); // format tanggal
        $total = Payment::whereDate('created_at', $date)->sum('bill');
        $salesData[] = $total;
    }

    $data['labels'] = json_encode($labels);
    $data['salesData'] = json_encode($salesData);

    // Progress Reservasi Status 'Process' Hari Ini
    $totalToday = DB::table('services')
        ->whereDate('service_date', $today)
        ->count();

    // Reservasi yang status-nya masih "Process"
    $processToday = DB::table('services')
        ->whereDate('service_date', $today)
        ->where('status', 'Process')
        ->count();

    // Hitung progres (yang masih Process)
    $progress = $totalToday > 0 ? round(($processToday / $totalToday) * 100) : 0;

    $data['progress_process'] = $progress;

    return view('home', $data);
}



}
