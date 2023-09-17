<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChiTietXuatKho;
use App\Models\ChiTietHangHoa;
use App\Models\HangHoa;
use App\Models\LoaiHang;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = date('Y-m-d');
        $tien_xuat_kho = ChiTietXuatKho::whereDate('created_at', $today)
            ->selectRaw('SUM(so_luong * gia_xuat) as thanh_tien')
            ->value('thanh_tien');

        $tien_nhap_kho = ChiTietHangHoa::whereDate('created_at', $today)
            ->selectRaw('SUM(so_luong_goc * gia_nhap) as tong_tien')
            ->value('tong_tien');

        $xuat_kho = ChiTietXuatKho::whereDate('created_at', $today)->get();
        $nhap = 0;
        foreach ($xuat_kho as $item) {
            $nhap += ($item->getChiTiet->gia_nhap * $item->so_luong);
        }

        $lai = $tien_xuat_kho - $nhap;

        $so_luong_hang_hoa = HangHoa::count();
        $so_luong_loai_hang = LoaiHang::count();

        $so_luong_het_hang = HangHoa::withSum(['getChiTiet' => function ($query) {
            $query->selectRaw('so_luong');
        }], 'so_luong')
            ->havingRaw('get_chi_tiet_sum_so_luong = 0 or get_chi_tiet_sum_so_luong IS NULL')
            ->count();

        $doanh_thu = HangHoa::whereHas('getChiTietXuatKho')->take(5)->get();

        foreach ($doanh_thu as $item) {
            $dt_xuat = $item->getChiTietXuatKho->sum(function ($h) {
                return $h->so_luong * $h->gia_xuat;
            });

            $dt_so_luong = $item->getChiTietXuatKho->sum(function ($h) {
                return $h->so_luong;
            });

            $item['doanh_thu'] = $dt_xuat;
            $item['so_luong'] = $dt_so_luong;
        };

        return view('dashboard', compact('so_luong_hang_hoa', 'so_luong_loai_hang', 'so_luong_het_hang', 'tien_nhap_kho', 'tien_xuat_kho', 'lai', 'doanh_thu'));
    }

    public function doanhThu()
    {
        $start = Carbon::now()->subMonths(11)->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $doanh_thu = ChiTietXuatKho::selectRaw('MONTH(created_at) as month, SUM(so_luong * gia_xuat) as thanh_tien')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $values = [];

        for ($i = 0; $i < 12; $i++) {
            $month = $start->copy()->addMonths($i)->month;
            $labels[] = $month;
            $dt = $doanh_thu->where('month', $month)->first();
            $values[] = $dt ? $dt->thanh_tien : 0;
        }

        return response()->json([
            'labels' => $labels,
            'values' => $values,
        ]);
    }
}
