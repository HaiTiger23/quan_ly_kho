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
        Schema::create('chi_tiet_phieu_xuat', function (Blueprint $table) {
            $table->id();
            $table->string('ma_phieu_xuat')->references('ma_phieu_xuat')->on('phieu_xuat')->cascadeOnDelete();
            $table->foreignId('id_chi_tiet_hang_hoa')->nullable()->constrained('chi_tiet_hang_hoa')->nullOnDelete();
            $table->integer('so_luong');
            $table->string('gia_xuat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_phieu_xuat');
    }
};
