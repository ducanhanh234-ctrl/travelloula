<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * Thêm tài khoản trực tiếp gửi đánh giá.
         */
        if (!Schema::hasColumn('danh_gia', 'nguoi_dung_id')) {
            Schema::table('danh_gia', function (Blueprint $table) {
                $table->foreignId('nguoi_dung_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->nullOnDelete();
            });
        }

        /*
         * Người dùng không cần đặt tour nên trường hành khách
         * phải cho phép NULL.
         */
        DB::statement("
            ALTER TABLE danh_gia
            MODIFY khach_hang_dat_tour_id BIGINT UNSIGNED NULL
        ");

        /*
         * Đánh giá hiển thị ngay, không cần admin duyệt.
         */
        DB::statement("
            ALTER TABLE danh_gia
            MODIFY hien_thi TINYINT(1) NOT NULL DEFAULT 1
        ");
    }

    public function down(): void
    {
        /*
         * Xóa những đánh giá không liên kết với đơn đặt tour
         * trước khi trả cấu trúc cũ.
         */
        DB::table('danh_gia')
            ->whereNull('khach_hang_dat_tour_id')
            ->delete();

        DB::statement("
            ALTER TABLE danh_gia
            MODIFY khach_hang_dat_tour_id BIGINT UNSIGNED NOT NULL
        ");

        if (Schema::hasColumn('danh_gia', 'nguoi_dung_id')) {
            Schema::table('danh_gia', function (Blueprint $table) {
                $table->dropConstrainedForeignId('nguoi_dung_id');
            });
        }
    }
};