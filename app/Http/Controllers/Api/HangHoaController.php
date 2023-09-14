<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChiTietHangHoa;
use App\Models\HangHoa;
use Illuminate\Http\Request;
use App\Http\Requests\ExcelRequest;
use App\Imports\HangHoaImport;
use Maatwebsite\Excel\Facades\Excel;


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
                $tong = $chi_tiet_hang_hoa->sum(function ($h) {
                    return $h->gia_nhap * $h->so_luong;
                });
                $hang_hoa->tong = $tong;
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
                $tong = $chi_tiet_hang_hoa->sum(function ($h) {
                    return $h->gia_nhap * $h->so_luong;
                });
                $product->tong = $tong;
                $product->details = $chi_tiet_hang_hoa;
            }
            return $this->successResponse("Successfully", $products);
        } catch (\Throwable $th) {
            return $this->errorResponse("Error", $th->getMessage());
        }
    }
}

