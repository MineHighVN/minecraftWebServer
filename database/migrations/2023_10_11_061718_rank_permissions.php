<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\RankPermission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rank_permissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rankId')->unsigned();
            $table->bigInteger('permissionId')->unsigned();

            $table->foreign('rankId')->references('id')->on('ranks')->onDelete('cascade');
            $table->foreign('permissionId')->references('id')->on('permissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rank_permissions');
    }
};
