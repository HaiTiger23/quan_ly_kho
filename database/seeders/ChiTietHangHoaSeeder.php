<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class ChiTietHangHoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 500) as $index) {
            DB::table('chi_tiet_hang_hoa')->insert([
                'ma_phieu_nhap' => 'PN' . $faker->numberBetween(1, 100),
                'ma_hang_hoa' => 'DTC' . $faker->numberBetween(1, 500),
                'ma_ncc' => 'NCC' . $faker->numberBetween(1, 50),
                'so_luong' => $faker->numberBetween(1, 1000),
                'so_luong_goc' => $faker->numberBetween(1, 1000),
                'id_trang_thai' => $faker->numberBetween(1, 3),
                'gia_nhap' =>  $faker->numberBetween(10000, 100000),
                'ngay_san_xuat' => $faker->date,
                'tg_bao_quan' => $faker->numberBetween(10, 300),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
