<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class HangHoaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 500) as $index) {
            DB::table('hang_hoa')->insert([
                'ma_hang_hoa' => 'DTC' . $index,
                'ten_hang_hoa' => $faker->text(20),
                'mo_ta' => $faker->text,
                'id_loai_hang' => $faker->numberBetween(1, 50),
                'don_vi_tinh' => 'sản phẩm',
                'gia_ban' => $faker->numberBetween(10000, 100000),
                'barcode' => 'DTC' . $index,
                'img' => $faker->text,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
