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
        Schema::table('users', function (Blueprint $table) {
            $table->string('otp')->nullable()->after('password');

            $table->boolean('otp_verified')->default(false)->after('otp');

            $table->integer('otp_attempts')->default(0)->after('otp_verified');

            $table->timestamp('otp_expired_at')->nullable()->after('otp_attempts');
            $table->string('password_reset_token')->nullable();
            $table->timestamp('password_reset_token_expired_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'otp',
                'otp_verified',
                'otp_attempts',
                'otp_expired_at',
                'password_reset_token',
                'password_reset_token_expired_at'
            ]);
        });
    }
};
