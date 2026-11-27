<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fixed_deposits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->restrictOnDelete();

            $table->foreignId('account_id')
                ->constrained('accounts')
                ->restrictOnDelete();

            $table->string('deposit_number')->unique();

            $table->decimal('principal_amount', 15, 2);

            $table->decimal('interest_rate', 5, 2)->default(8.00);

            $table->unsignedTinyInteger('duration_months');

            $table->date('start_date');

            $table->date('maturity_date');

            $table->decimal('expected_interest', 15, 2);

            $table->decimal('maturity_amount', 15, 2);

            $table->enum('status', ['active', 'completed'])
                ->default('active');

            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fixed_deposits');
    }
};
