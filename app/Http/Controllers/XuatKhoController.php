<?php

namespace App\Http\Controllers;

use App\Models\XuatKho;
use App\Models\HangHoa;
use App\Models\ChiTietXuatKho;
use App\Models\ChiTietHangHoa;
use App\Exports\XuatKhoExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class XuatKhoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ma_phieu_xuat = XuatKho::latest()->first()->ma_phieu_xuat ?? "PX000000";

        $lastNumber = (int) substr($ma_phieu_xuat, 2);
        $lastNumberLength = strlen((string)substr($ma_phieu_xuat, 2));
        $nextNumber = $lastNumber + 1;
        $ma_phieu_xuat = 'PX' . str_pad($nextNumber, $lastNumberLength, '0', STR_PAD_LEFT);

        $phieu_xuat = [];

        XuatKho::orderBy('id', 'DESC')->chunkById(100, function ($chunk) use (&$phieu_xuat) {
            foreach ($chunk as $phieu) {
                $phieu_xuat[] = $phieu;
            }
        });

        return view('xuatkho.index', compact('phieu_xuat', 'ma_phieu_xuat'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $ma_phieu_xuat = XuatKho::latest()->first()->ma_phieu_xuat ?? "PX000000";

        $lastNumber = (int) substr($ma_phieu_xuat, 2);
        $lastNumberLength = strlen((string)substr($ma_phieu_xuat, 2));
        $nextNumber = $lastNumber + 1;
        $ma_phieu_xuat = 'PX' . str_pad($nextNumber, $lastNumberLength, '0', STR_PAD_LEFT);

        return view('xuatkho.create', compact('ma_phieu_xuat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $phieu_xuat = XuatKho::where('ma_phieu_xuat', $code)->firstOrFail();

        $chi_tiet_phieu_xuat = ChiTietXuatKho::where('ma_phieu_xuat', $code)->orderBy('id', 'DESC')->paginate(10);

        return view('xuatkho.show', compact('phieu_xuat', 'chi_tiet_phieu_xuat'));
    }

    public function export(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $dataExport = [];
        $errors = [];

        if (count($data) < 2) {
            return response()->json(['message' => 'Không có dữ liệu để xuất!']);
        }

        $validator = Validator::make($data[0], [
            'ma_phieu_xuat' => 'required|max:20|unique:phieu_xuat,ma_phieu_xuat',
            'ngay_xuat' => 'required',
            'id_user' => 'required|integer',
            'khach_hang' => 'required',
            'dia_chi' => 'required',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->messages() as $rowErrors) {
                $errors[] = $rowErrors;
            }
        }

        if ($validator->fails()) {
            return response()->json(['message' => 'Có lỗi xảy ra trong quá trình nhập dữ liệu. Vui lòng thử lại sau!', 'errors' => $errors], 400);
        }

        $mo_ta = json_decode($data[0]['mo_ta'], true);

        $phieu_xuat = XuatKho::create([
            'ma_phieu_xuat' => $data[0]['ma_phieu_xuat'],
            'khach_hang' => $data[0]['khach_hang'],
            'dia_chi' => $data[0]['dia_chi'],
            'ngay_xuat' => $data[0]['ngay_xuat'],
            'id_user' => $data[0]['id_user'],
            'mo_ta' => strlen($mo_ta) == 0 ? 'Không có mô tả cụ thể!' : $mo_ta
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

        $dataExport = collect($data)
            ->skip(1)
            ->map(function ($item, $index) use ($data) {
                $cthh = ChiTietHangHoa::find($item['id_chi_tiet_hang_hoa']);
                $hh = HangHoa::where('ma_hang_hoa', $cthh->ma_hang_hoa)->first();

                ChiTietXuatKho::create([
                    'ma_phieu_xuat' => $data[0]['ma_phieu_xuat'],
                    'id_chi_tiet_hang_hoa' => $item['id_chi_tiet_hang_hoa'],
                    'so_luong' => $item['so_luong'],
                    'gia_xuat' => $item['gia_xuat']
                ]);

                $gia_xuat = $item['so_luong'] * $item['gia_xuat'];

                $cthh->so_luong -= $item['so_luong'];
                $cthh->so_luong == 0 ? $cthh->id_trang_thai = 1 : $cthh->so_luong;
                $cthh->save();

                return [
                    $index,
                    $cthh->ma_hang_hoa,
                    $hh->ten_hang_hoa,
                    $hh->don_vi_tinh,
                    $item['so_luong'],
                    $item['gia_xuat'],
                    $gia_xuat,
                    Carbon::createFromFormat('Y-m-d', $cthh->ngay_san_xuat)->format('d-m-Y'),
                    $cthh->tg_bao_quan,
                    $cthh->getNhaCungCap->ten_ncc,
                ];
            })
            ->toArray();

        $excel = Excel::download(new XuatKhoExport($dataExport), 'xuat-kho.xlsx', \Maatwebsite\Excel\Excel::XLSX);

        $excelPath = $excel->getFile()->getPathname();
        Storage::disk('public')->put('excel/xuat-kho.xlsx', file_get_contents($excelPath));

        return response()->json([
            'type' => 'export',
            'message' => 'Xuất file excel thành công. Bạn có muốn tải về không?',
            'downloadUrl' => route('xuat-kho.download')
        ]);
    }

    public function download()
    {
        $file = public_path('storage/excel/xuat-kho.xlsx');
        return response()->download($file, 'xuat-kho.xlsx');
    }
}
