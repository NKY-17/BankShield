
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fraud_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')
                ->constrained('accounts')
                ->cascadeOnDelete();

            $table->decimal('amount', 15, 2);
            $table->text('reason');
            $table->enum('status', [
                'pending',
                'confirmed',
                'denied'
            ])->default('pending');

            $table->timestamps();
        });

        Schema::create('fraud_cases', function (Blueprint $table) {
            $table->id();

            $table->foreignId('fraud_log_id')
                ->unique()
                ->constrained('fraud_logs')
                ->cascadeOnDelete();

            $table->enum('stage', [
                'new',
                'under_investigation',
                'resolved'
            ])->default('new');

            $table->text('investigation_notes')->nullable();

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fraud_cases');
        Schema::dropIfExists('fraud_logs');
    }
};
