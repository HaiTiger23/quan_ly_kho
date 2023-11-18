<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NhaCungCap;
use Illuminate\Http\Request;

class NhaCungCapController extends Controller
{
    function viewAll() {
        $listProvider = NhaCungCap::all();
        return $this->successResponse("Successfully", $listProvider);
    }
}
