<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable();  // Thêm cột role_id
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');  // Tạo quan hệ với bảng roles
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);  // Xóa foreign key
            $table->dropColumn('role_id');  // Xóa cột role_id
        });
    }
};
