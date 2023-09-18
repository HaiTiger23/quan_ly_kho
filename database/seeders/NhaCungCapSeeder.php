<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class NhaCungCapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            DB::table('nha_cung_cap')->insert([
                'ma_ncc' => $faker->text(10),
                'ten_ncc' => $faker->name,
                'dia_chi' => $faker->text(30),
                'id_trang_thai' => $faker->numberBetween(1, 3),
                'sdt' => '0789338359',
                'mo_ta' => $faker->text(30),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
