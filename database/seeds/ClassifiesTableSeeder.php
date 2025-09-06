<?php

use Illuminate\Database\Seeder;

class ClassifiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classifies')->insert([
            // Giới tính
            [
                'constant_id' => 1,
                'display_no' => 1,
                'value' => 1,
                'name' => 'Nam',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'constant_id' => 1,
                'display_no' => 2,
                'value' => 2,
                'name' => 'Nữ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            // Quan hệ
            [
                'constant_id' => 2,
                'display_no' => 1,
                'value' => 1,
                'name' => 'Con trai',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'constant_id' => 2,
                'display_no' => 2,
                'value' => 2,
                'name' => 'Con gái',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'constant_id' => 2,
                'display_no' => 4,
                'value' => 4,
                'name' => 'Vợ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            // Chế độ tìm kiếm
            [
                'constant_id' => 5,
                'display_no' => 1,
                'value' => 'base',
                'name' => 'Chọn gốc phả đồ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'constant_id' => 5,
                'display_no' => 2,
                'value' => 'view',
                'name' => 'Tìm người trong phả đồ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'constant_id' => 5,
                'display_no' => 3,
                'value' => 'statistic',
                'name' => 'Thống kê con cháu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'constant_id' => 5,
                'display_no' => 4,
                'value' => 'branch',
                'name' => 'Thêm chi phái để nhập',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'constant_id' => 5,
                'display_no' => 5,
                'value' => 'modify',
                'name' => 'Tìm để sửa hoặc xóa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'constant_id' => 5,
                'display_no' => 6,
                'value' => 'manager',
                'name' => 'Thêm quản trị viên',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            // Vai trò quản trị
            [
                'constant_id' => 6,
                'display_no' => 1,
                'value' => '1',
                'name' => 'Cập nhật gia phả',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'constant_id' => 6,
                'display_no' => 2,
                'value' => '2',
                'name' => 'Quản lý trang web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            // Loại sự kiện nhật ký
            [
                'constant_id' => 9,
                'display_no' => 1,
                'value' => 1,
                'name' => 'Tạo mới',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'constant_id' => 9,
                'display_no' => 2,
                'value' => 2,
                'name' => 'Sửa đổi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'constant_id' => 9,
                'display_no' => 3,
                'value' => 3,
                'name' => 'Xóa bỏ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            // Bảng khôi phục dữ liệu
            [
                'constant_id' => 10,
                'display_no' => 1,
                'value' => 'members',
                'name' => 'Thành viên',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'constant_id' => 10,
                'display_no' => 2,
                'value' => 'users',
                'name' => 'Quản trị viên',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'constant_id' => 10,
                'display_no' => 3,
                'value' => 'constants',
                'name' => 'Định danh',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'constant_id' => 10,
                'display_no' => 4,
                'value' => 'classifies',
                'name' => 'Danh mục',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            // Lệnh thực thi
            [
                'constant_id' => 11,
                'display_no' => 1,
                'value' => 'data:backup',
                'name' => 'Sao lưu dữ liệu thay đổi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'constant_id' => 11,
                'display_no' => 2,
                'value' => 'config:cache',
                'name' => 'Xóa cache cấu hình',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'modified_by' => 1,
            ],
        ]);
    }
}
