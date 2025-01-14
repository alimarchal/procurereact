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

            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('businesses')->onDelete('set null');
            // Basic Information
            $table->string('name');
            $table->string('name_arabic')->nullable();
            $table->string('email')->nullable();
            $table->string('ibr')->nullable();
            // Registration Numbers
            $table->string('cr_number', 50)->nullable();
            $table->string('vat_number', 50)->nullable();
            $table->string('vat_number_arabic')->nullable();
            // Contact Information
            $table->string('cell', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('phone', 20)->nullable();
            // Location Information
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            // Business Details
            $table->string('customer_industry')->nullable();
            $table->string('sale_type')->nullable();
            $table->string('article_no')->nullable();
            $table->string('business_type_english')->nullable();
            $table->string('business_type_arabic')->nullable();
            $table->text('business_description_english')->nullable();
            $table->text('business_description_arabic')->nullable();
            // Invoice Settings
            $table->string('invoice_side_arabic')->nullable();
            $table->string('invoice_side_english')->nullable();
            $table->string('english_description')->nullable();
            $table->string('arabic_description')->nullable();
            $table->decimal('vat_percentage', 5, 2)->nullable();
            $table->string('apply_discount_type')->nullable();
            $table->string('language')->nullable();
            $table->boolean('show_email_on_invoice')->default(false);
            // Website Information
            $table->string('website')->nullable();
            // Banking Information
            $table->string('bank_name')->nullable();
            $table->string('iban', 50)->nullable();
            // Type Information
            $table->string('company_type')->default('customer');
            // New Fields for File Uploads
            $table->string('company_logo')->nullable();
            $table->string('company_stamp')->nullable();
            // System Fields
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
