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
        Schema::create('businesses', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Foreign key referencing the users table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Business transaction amount
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('reference_number')->unique()->nullable();

            // Basic business information
            $table->string('name');
            $table->string('name_arabic')->nullable();
            $table->string('email')->nullable();

            // Registration numbers
            $table->string('cr_number', 50)->nullable();
            $table->string('vat_number', 50)->nullable();
            $table->string('vat_number_arabic')->nullable();

            // Contact information
            $table->string('cell', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('phone', 20)->nullable();

            // Location information
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();

            // Business details
            $table->string('customer_industry')->nullable();
            $table->string('sale_type')->nullable();
            $table->string('article_no')->nullable();

            // Invoice settings
            $table->decimal('vat_percentage', 5, 2)->nullable();
            $table->string('company_type')->default();
            $table->boolean('show_email_on_invoice')->default(false);

            // System fields
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
