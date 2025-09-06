<?php

use Illuminate\Database\Seeder;

class ConstantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('constants')->insert([
            [
                // 1
                'name' => 'Giới tính',
                'value' => 1,
                'array' => 1,
                'description' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // 2
                'name' => 'Quan hệ',
                'value' => 2,
                'array' => 1,
                'description' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // 3
                'name' => 'Số hệ đã mất',
                'value' => 12,
                'array' => 0,
                'description' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // 4
                'name' => 'Chi phái',
                'value' => 3,
                'array' => 1,
                'description' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // 5
                'name' => 'Chế độ tìm kiếm',
                'value' => 4,
                'array' => 1,
                'description' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // 6
                'name' => 'Vai trò quản trị',
                'value' => 5,
                'array' => 1,
                'description' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // 7
                'name' => 'Trang chủ',
                'value' => 6,
                'array' => 0,
                'description' => 'trang chủ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // 8
                'name' => 'Phả ký',
                'value' => 7,
                'array' => 0,
                'description' => 'Phả ký',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // 9
                'name' => 'Loại sự kiện nhật ký',
                'value' => 1,
                'is_array' => 1,
                'description' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // 10
                'name' => 'Bảng khôi phục dữ liệu',
                'value' => 1,
                'is_array' => 1,
                'description' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // 11
                'name' => 'Lệnh thực thi',
                'value' => 1,
                'is_array' => 1,
                'description' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
