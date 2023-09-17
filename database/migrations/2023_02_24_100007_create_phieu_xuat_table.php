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
        Schema::create('phieu_xuat', function (Blueprint $table) {
            $table->id();
            $table->string('ma_phieu_xuat')->unique();
            $table->string('khach_hang')->nullable();
            $table->string('don_gia');
            $table->date('ngay_xuat')->default(now()->toDateString());
            $table->text('mo_ta')->nullable();
            $table->foreignId('id_user')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phieu_xuat');
    }
};
