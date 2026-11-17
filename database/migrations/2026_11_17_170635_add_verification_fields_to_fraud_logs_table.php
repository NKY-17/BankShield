<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fraud_logs', function (Blueprint $table) {
            $table->string('verification_token_hash')
                ->nullable()
                ->unique();

            $table->timestamp('verification_expires_at')
                ->nullable();

            $table->timestamp('verified_at')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('fraud_logs', function (Blueprint $table) {
            $table->dropUnique(['verification_token_hash']);
            $table->dropColumn([
                'verification_token_hash',
                'verification_expires_at',
                'verified_at'
            ]);
        });
    }
};