<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id('role_permission_id');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('module_id');
            $table->boolean('read')->nullable()->default(false);
            $table->boolean('write')->nullable()->default(false);
            $table->boolean('update')->nullable()->default(false);
            $table->boolean('delete')->nullable()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
