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
        Schema::create('home_banners', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('button_url')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('home_banner_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_banner_id')->constrained('home_banners')->onDelete('cascade');
            $table->string('locale')->default('en');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('button_text')->nullable();
            $table->timestamps();

            $table->unique(['home_banner_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_banner_translations');
        Schema::dropIfExists('home_banners');
    }

};
