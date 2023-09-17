<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\TrangThai::create([
            'id' => 1,
            'ten_trang_thai' => 'Private'
        ]);
        \App\Models\TrangThai::create([
            'id' => 2,
            'ten_trang_thai' => 'Pending'
        ]);
        \App\Models\TrangThai::create([
            'id' => 3,
            'ten_trang_thai' => 'Public'
        ]);

        $this->call(LoaiHangTableSeeder::class);
        $this->call(HangHoaTableSeeder::class);
        $this->call(ChiTietHangHoaSeeder::class);

        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Minh Phạm',
            'email' => 'admin@admin.com',
            'gioi_tinh' => 'nam',
            'password' =>  bcrypt('password'),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@user.com',
            'gioi_tinh' => 'nam',
            'password' =>  bcrypt('password'),
        ]);
    }
}
