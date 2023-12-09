<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HangHoa extends Model
{
    use HasFactory;

    protected $table = 'hang_hoa';

    protected $guarded = ['id'];

    protected $fillable = [

    ];

    protected $hidden = [

    ];

    protected $casts = [

    ];

    public function getLoaiHang()
    {
        return $this->belongsTo(LoaiHang::class, 'id_loai_hang');
    }

    public function getChiTiet()
    {
        return $this->hasMany(ChiTietHangHoa::class, 'ma_hang_hoa', 'ma_hang_hoa');
    }
    function QrNhapHangs() {
        return $this->hasMany(QrNhapHang::class, 'hang_hoa_id');
    }

    public function getChiTietXuatKho()
    {
        return $this->hasManyThrough(ChiTietXuatKho::class, ChiTietHangHoa::class, 'ma_hang_hoa', 'id_chi_tiet_hang_hoa', 'ma_hang_hoa', 'id');
    }
}
