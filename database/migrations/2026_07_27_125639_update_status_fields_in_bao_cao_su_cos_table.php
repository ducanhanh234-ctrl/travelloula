<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE bao_cao_su_cos
            MODIFY trang_thai ENUM(
                'moi',
                'da_tiep_nhan',
                'dang_xu_ly',
                'da_xu_ly',
                'tu_choi'
            ) NOT NULL DEFAULT 'moi'
        ");

        DB::statement("
            ALTER TABLE bao_cao_su_cos
            MODIFY muc_do ENUM(
                'thap',
                'trung_binh',
                'cao',
                'khan_cap'
            ) NOT NULL DEFAULT 'trung_binh'
        ");

        DB::statement("
            ALTER TABLE bao_cao_su_cos
            MODIFY loai_su_co ENUM(
                'khach_hang',
                'phuong_tien',
                'thoi_tiet',
                'lich_trinh',
                'dich_vu',
                'an_ninh',
                'suc_khoe',
                'khac'
            ) NOT NULL
        ");
    }

    public function down(): void
    {
        DB::table('bao_cao_su_cos')
            ->whereIn('trang_thai', ['moi', 'da_tiep_nhan'])
            ->update(['trang_thai' => 'cho_xu_ly']);

        DB::table('bao_cao_su_cos')
            ->where('trang_thai', 'tu_choi')
            ->update(['trang_thai' => 'da_xu_ly']);

        DB::table('bao_cao_su_cos')
            ->where('muc_do', 'khan_cap')
            ->update(['muc_do' => 'cao']);

        DB::table('bao_cao_su_cos')
            ->whereIn('loai_su_co', ['dich_vu', 'an_ninh', 'suc_khoe'])
            ->update(['loai_su_co' => 'khac']);

        DB::statement("
            ALTER TABLE bao_cao_su_cos
            MODIFY trang_thai ENUM(
                'cho_xu_ly',
                'dang_xu_ly',
                'da_xu_ly'
            ) NOT NULL DEFAULT 'cho_xu_ly'
        ");

        DB::statement("
            ALTER TABLE bao_cao_su_cos
            MODIFY muc_do ENUM(
                'thap',
                'trung_binh',
                'cao'
            ) NOT NULL
        ");

        DB::statement("
            ALTER TABLE bao_cao_su_cos
            MODIFY loai_su_co ENUM(
                'khach_hang',
                'phuong_tien',
                'thoi_tiet',
                'lich_trinh',
                'khac'
            ) NOT NULL
        ");
    }
};
