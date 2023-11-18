<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HangHoa;
use App\Models\LoaiHang;
use Illuminate\Http\Request;

class LoaiHangController extends Controller
{
    function viewAll() {
        $ListHangHoa = LoaiHang::all();
        return $this->successResponse("successfully", $ListHangHoa);
    }
}
