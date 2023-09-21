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
        Schema::create('phieu_nhap', function (Blueprint $table) {
            $table->id();
            $table->string('ma_phieu_nhap')->unique();
            $table->foreignId('id_user')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('ma_ncc')->references('ma_ncc')->on('nha_cung_cap')->nullOnDelete();
            $table->date('ngay_nhap')->default(now()->toDateString());
            $table->text('mo_ta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phieu_nhap');
    }
};
