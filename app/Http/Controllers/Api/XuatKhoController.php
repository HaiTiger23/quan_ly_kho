<?php

namespace App\Http\Controllers\Api;

use App\Events\AddCart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Models\XuatKho;
use App\Models\ChiTietXuatKho;
use App\Models\ChiTietHangHoa;
use App\Models\HangHoa;
use App\Exports\XuatKhoExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class XuatKhoController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('searchInput');

        $selectedValues = $request->input('selectedValues', []);

        $hang_hoa = ChiTietHangHoa::where('ma_hang_hoa', 'LIKE', "%{$query}%")
            ->orWhereHas('getHangHoa', function ($q) use ($query) {
                $q->where('ten_hang_hoa', 'LIKE', "%{$query}%");
            })->with('getHangHoa')->get();

        $result = [];

        foreach ($hang_hoa as $item) {
            if (!in_array($item->id, $selectedValues) && $item->so_luong > 0) {
                $result[] = $item;
            }
        }

        return response()->json($result);
    }

    public function store(Request $request)
    {

        DB::beginTransaction();
        try {

            $phieu_xuat = XuatKho::create([
                'ma_phieu_xuat' => $request->ma_phieu_xuat,
                'khach_hang' => $request->khach_hang,
                'ngay_xuat' => $request->ngay_xuat,
                'mo_ta' => $request->mo_ta,
                'don_gia' => $request->don_gia_input,
                'id_user' => $request->nhanvien_id,
            ]);

            for ($i = 0; $i < count($request['ma_hang_hoa']); $i++) {
                $hangHoa = HangHoa::where('id', $request->id[$i])->first();
                $chiTietHangHoa = ChiTietHangHoa::where('ma_hang_hoa', $hangHoa->ma_hang_hoa)->first();
                ChiTietXuatKho::create([
                    'ma_phieu_xuat' => $phieu_xuat->ma_phieu_xuat,
                    'id_chi_tiet_hang_hoa' => $chiTietHangHoa->id,
                    'so_luong' => $request->so_luong[$i],
                    'gia_xuat' => $request->gia_ban[$i]
                ]);
                $chiTietHangHoa->so_luong -= $request->so_luong[$i];
                $chiTietHangHoa->save();
            }
            DB::commit();
            return redirect('/xuat-kho')->with('success', 'xuất hóa đơn thành công');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error(date("Y-m-d H:i:s") . $th->getMessage());
        }
    }

    public function addToCard(Request $request)
    {

        $sanPham = HangHoa::where('ma_hang_hoa', $request->maSanPham)->first();

        event($event = new AddCart($sanPham));
    }

    public function saleHistory()
    {
        try {
            $user = auth("sanctum")->user();
            $saleHistory = XuatKho::all();

            foreach ($saleHistory as $history) {
                foreach ($history->getChiTiet as $hang_hoa) {
                    $hang = $hang_hoa->getChiTiet->getHangHoa;
                    if (isset($hang->img)) {
                        $hang->img = asset('storage/images/hanghoa/' . $hang->img);
                    } else {
                        $hang->img = asset('assets/images/hanghoa/hanghoa.png');
                    }
                    $history['hang_hoa'] = $hang;
                }
            }

            return $this->successResponse('Thành công', $saleHistory);
        } catch (\Exception $e) {
            return $this->errorResponse('Xuất hiện lỗi: ' . $e->getMessage());
        }
    }
}
