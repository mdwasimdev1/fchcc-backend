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
        Schema::create('system_setting_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('system_setting_id')->constrained()->cascadeOnDelete();
            $table->string('locale');

             // Translatable fields
             $table->string('system_title', 150)->nullable();
             $table->string('system_short_title', 100)->nullable();
             $table->string('company_name', 150)->nullable();
             $table->string('tag_line', 255)->nullable();
             $table->text('copyright_text')->nullable();

            $table->string('admin_title', 150)->nullable();
            $table->string('admin_short_title', 100)->nullable();
            $table->text('admin_copyright_text')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_setting_translations');
    }
};
