<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chi_tiet_hang_hoa', function (Blueprint $table) {
            $table->id();
            $table->string('ma_hang_hoa');
            $table->string('ma_ncc');
            $table->integer('so_luong')->unsigned();
            $table->integer('gia_nhap')->unsigned();
            $table->date('ngay_san_xuat')->default(now()->toDateString());
            $table->integer('tg_bao_quan')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_hang_hoa');
    }
};
