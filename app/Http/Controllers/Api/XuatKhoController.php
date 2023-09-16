<?php

namespace App\Http\Controllers\Api;

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
        $data = json_decode($request->getContent(), true);
        $errors = [];

        if (count($data) < 2) {
            return response()->json(['message' => 'Vui lòng thêm hàng hóa cần xuất kho!']);
        }

        $validator = Validator::make($data[0], [
            'ma_phieu_xuat' => 'required|max:20|unique:phieu_xuat,ma_phieu_xuat',
            'ngay_xuat' => 'required',
            'id_user' => 'required|integer',
            'dia_chi' => 'required',
            'khach_hang' => 'required|string',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->messages() as $rowErrors) {
                $errors[] = $rowErrors;
            }
        }

        if ($validator->fails()) {
            return response()->json(['message' => 'Có lỗi xảy ra trong quá trình nhập dữ liệu. Vui lòng thử lại sau!', 'errors' => $errors], 400);
        }

        $phieu_xuat = XuatKho::create([
            'ma_phieu_xuat' => $data[0]['ma_phieu_xuat'],
            'khach_hang' => $data[0]['khach_hang'],
            'dia_chi' => $data[0]['dia_chi'],
            'ngay_xuat' => $data[0]['ngay_xuat'],
            'id_user' => $data[0]['id_user'],
            'mo_ta' => strlen($data[0]['mo_ta']) == 0 ? 'Không có mô tả cụ thể!' : $data[0]['mo_ta']
        ]);

        for ($i = 1; $i < count($data); $i++) {
            $validator = Validator::make($data[$i], [
                'id_chi_tiet_hang_hoa' => 'required|integer|exists:chi_tiet_hang_hoa,id',
                'so_luong' => 'required|integer|min:1',
                'gia_xuat' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $rowErrors) {
                    $errors[] = $rowErrors;
                }
            }

            $cthh = ChiTietHangHoa::find($data[$i]['id_chi_tiet_hang_hoa']);

            if (($cthh->so_luong - $data[$i]['so_luong']) < 0) {
                $errors[] = "Số lượng nhập vào của " . $cthh->getHangHoa->ten_hang_hoa . " vượt quá số lượng hiện có trong kho.";
            }
        }

        if (count($errors) > 0) {
            XuatKho::destroy($phieu_xuat->id);
            return response()->json(['errors' => $errors], 400);
        }

        for ($i = 1; $i < count($data); $i++) {
            $cthh = ChiTietHangHoa::find($data[$i]['id_chi_tiet_hang_hoa']);

            ChiTietXuatKho::create([
                'ma_phieu_xuat' => $data[0]['ma_phieu_xuat'],
                'id_chi_tiet_hang_hoa' => $data[$i]['id_chi_tiet_hang_hoa'],
                'so_luong' => $data[$i]['so_luong'],
                'gia_xuat' => $data[$i]['gia_xuat']
            ]);
            $cthh->so_luong -= $data[$i]['so_luong'];
            $cthh->so_luong == 0 ? $cthh->id_trang_thai = 1 : $cthh->so_luong;
            $cthh->save();
        }

        return response()->json(['message' => 'Xuất kho thành công. Bạn sẽ được chuyển hướng sau vài giây!', 'type' => 'success', 'redirect' => route('xuat-kho.index')], 200);
    }

    public function addToCard(Request $request)
    {
        \Illuminate\Support\Facades\Redis::set('test_key', 'Hello, Redis!');
        $value = \Illuminate\Support\Facades\Redis::get('test_key');

        return response()->json(['value' => $value]);
    }
}
