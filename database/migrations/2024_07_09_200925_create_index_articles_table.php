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
        Schema::create('index_articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('meta_description');
            $table->string('heading1')->nullable();
            $table->string('heading2')->nullable();
            $table->string('heading3')->nullable();
            $table->string('banner_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('index_articles');
    }
};
