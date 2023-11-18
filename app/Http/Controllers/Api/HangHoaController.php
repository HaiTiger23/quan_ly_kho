<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HangHoaStoreRequest;
use App\Models\ChiTietHangHoa;
use App\Models\HangHoa;
use Illuminate\Http\Request;
use App\Http\Requests\ExcelRequest;
use App\Imports\HangHoaImport;
use Maatwebsite\Excel\Facades\Excel;
use Validator;


class HangHoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function import(ExcelRequest $request)
    {
        $file = $request->file('excel_file');
        Excel::import(new HangHoaImport(), $file);


        return response()->json(['message' => 'Nhập hàng hóa thành công!', 'type' => 'success', 'redirect' => route('hang-hoa.index')]);
    }
    function viewFromBarcode(Request $request)
    {
        try {
            $request->validate([
                'product_code' => 'required',
            ]);
            $hang_hoa = HangHoa::where("barcode", $request->product_code)->first();

            if ($hang_hoa) {
                $chi_tiet_hang_hoa = ChiTietHangHoa::where('ma_hang_hoa', $hang_hoa->ma_hang_hoa)->where('id_trang_thai', 3)->get();
                $so_luong = $chi_tiet_hang_hoa->sum(function ($h) {
                    return $h->so_luong;
                });
                $hang_hoa->img = asset('images/hanghoa/' . $hang_hoa->img);
                $hang_hoa->so_luong = $so_luong;
                $hang_hoa->details = $chi_tiet_hang_hoa;
                return $this->successResponse("Successfully", $hang_hoa);
            }
            return $this->errorResponse("Failed", $hang_hoa);
        } catch (\Throwable $th) {
            return $this->errorResponse("Error", $th->getMessage());
        }
    }
    function viewAll()
    {
        try {
            $products = HangHoa::all();
            foreach ($products as  $product) {
                $chi_tiet_hang_hoa = ChiTietHangHoa::where('ma_hang_hoa', $product->ma_hang_hoa)->where('id_trang_thai', 3)->get();
                $so_luong = $chi_tiet_hang_hoa->sum(function ($h) {
                    return $h->so_luong;
                });
                $product->img = asset('storage/images/hanghoa/' . $product->img);
                $product->so_luong = $so_luong;
                $product->details = $chi_tiet_hang_hoa;
            }
            return $this->successResponse("Successfully", $products);
        } catch (\Throwable $th) {
            return $this->errorResponse("Error", $th->getMessage());
        }
    }
    function store(Request $request)
    {
        return $this->successResponse("Successfully", $request->all());
    }
    function create(Request $request) {
       $validator = Validator::make($request->all(),[
            'ten_hang_hoa' => 'required|max:255',
            'ma_hang_hoa' => 'required|max:100|unique:hang_hoa,ma_hang_hoa',
            'id_loai_hang' => 'required|integer|exists:loai_hang,id',
            'don_vi_tinh' => 'required|max:50',
            'gia_ban' => 'required|integer|min:0',
            'change_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'barcode' => ['required', 'max:20', 'regex:/^[A-Z0-9]+$/', 'unique:hang_hoa,barcode'],
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()],200);
        }
        $data = $request->all();
        $file_name = "hanghoa.jpg";

        if ($request->hasFile('change_img')) {
            $img = $request->file('change_img');
            $file_name = time() . '.' . $img->getClientOriginalExtension();
            $path = $request->file('change_img')->storeAs('public/images/hanghoa', $file_name);
        }
        if($request->mo_ta) {
            $mo_ta = json_decode($request->mo_ta)->ops[0]->insert;
        }else {
            $mo_ta = "";
        }

        $hang_hoa = HangHoa::create([
            'ma_hang_hoa' => $data['ma_hang_hoa'],
            'ten_hang_hoa' => $data['ten_hang_hoa'],
            'id_loai_hang' => $data['id_loai_hang'],
            'don_vi_tinh' => $data['don_vi_tinh'],
            'gia_ban' => $data['gia_ban'],
            'barcode' => $data['barcode'] <= 0 ? null : $data['barcode'],
            'img' => $file_name,
            'mo_ta' => strlen($mo_ta) == 0 ? 'Không có mô tả cụ thể!' : $mo_ta
        ]);

        if ($hang_hoa) {
          return $this->successResponse("create success");
        } else {
            if ($request->hasFile('change_img')) {
                unlink(storage_path('app/public/images/hanghoa/' . $file_name));
            }
           return $this->errorResponse("create error");
        }
    }
}
