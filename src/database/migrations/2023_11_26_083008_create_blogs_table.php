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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id('blog_id');
            $table->string('title');
            $table->string('url')->unique();
            $table->longText('description');
            $table->date('published_at');
            $table->date('publish_until')->nullable();
            $table->boolean('publish_forever')->nullable()->default(false);
            $table->unsignedBigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
