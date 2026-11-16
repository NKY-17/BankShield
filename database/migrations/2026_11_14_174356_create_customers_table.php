
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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            // Customer identification
            $table->string('customer_number')->unique();

            // Link to login account (optional)
            $table->foreignId('user_id')
                ->nullable()
                ->unique()
                ->constrained('users')
                ->nullOnDelete();

            // Personal information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable()->unique();
            $table->string('phone');
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();

            // Address and occupation
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('occupation')->nullable();

            // Customer status
            $table->string('status')->default('active');

            // Staff member who registered the customer
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
