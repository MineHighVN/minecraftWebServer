<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->integer('permId')->unsigned();
            $table->string('displayName');
        });

        $permissions = array(
            1 => "Tạo bài viết",
            2 => "Chỉnh sửa quyền",
            3 => "Cảnh báo người dùng",
            4 => "Chỉnh sửa tài khoản người dùng",
            5 => "Thay đổi luật"
        );

        foreach ($permissions as $index => $permission) {
            $permissionDB = new Permission();
            $permissionDB->permId = $index;
            $permissionDB->displayName = $permission;
            $permissionDB->save();
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
