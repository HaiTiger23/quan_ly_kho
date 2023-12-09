<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrNhapHang extends Model
{
    use HasFactory;
    protected $table = 'qr_nhap_hangs';
    protected $guarded = ['id'];

    public function phienNhapHang() {
        return $this->belongsTo(PhienNhapHang::class, 'phien_nhap_hang_id');
    }
    public function hangHoa() {
        return $this->belongsTo(HangHoa::class, 'hang_hoa_id');
    }


}
