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
        Schema::create('scholarship_banners', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('button_url')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('scholarship_banner_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scholarship_banner_id')->constrained('scholarship_banners')->onDelete('cascade');
            $table->string('locale')->default('en');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('button_text')->nullable();
            $table->timestamps();

            $table->unique(['scholarship_banner_id', 'locale'], 'scholarship_banner_locale_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarship_banner_translations');
        Schema::dropIfExists('scholarship_banners');
    }
};
