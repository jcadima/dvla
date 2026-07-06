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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('admin_logo')->nullable();
            $table->string('mobile_logo')->nullable();
            $table->string('footer_logo')->nullable();
            $table->string('google_ga')->nullable();
            $table->text('general_scripts')->nullable();
            $table->string('copyright')->nullable();
            $table->string('recipient')->nullable();
            $table->boolean('logging_enabled')->default(false);
            $table->enum('sitemap_mode', ['all', 'custom'])->default('all');
            $table->json('sitemap_included_routes')->nullable();
            $table->json('sitemap_excluded_routes')->nullable();
            $table->boolean('sitemap_include_posts')->default(true);
            $table->boolean('sitemap_include_pages')->default(true);
            $table->boolean('sitemap_include_static_routes')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
