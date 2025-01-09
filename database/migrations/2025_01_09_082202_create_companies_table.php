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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Basic Information
            $table->string('name');
            $table->string('name_arabic')->nullable();
            $table->string('email')->nullable();

            // Registration Numbers
            $table->string('cr_number', 50)->nullable();              // 1010803499
            $table->string('vat_number', 50)->nullable();             // 311304660300003
            $table->string('vat_number_arabic')->nullable();                 // ٣١١٣٠٤٦٦٠٣٠٠٠٠٣

            // Contact Information
            $table->string('cell', 20)->nullable();                   // 0505709548
            $table->string('mobile', 20)->nullable();                 // From existing migration
            $table->string('phone', 20)->nullable();                  // From existing migration

            // Location Information
            $table->string('address')->nullable();                    // Riyadh
            $table->string('city')->nullable();                       // From existing migration
            $table->string('country')->nullable();                    // From existing migration

            // Business Details
            $table->string('customer_industry')->nullable();          // Regular
            $table->string('sale_type')->nullable();                  // Manual
            $table->string('article_no')->nullable();                 // KE
            $table->string('business_type_english')->nullable();      // Riyadh - Dammam Road 2591
            $table->string('business_type_arabic')->nullable();       // الرياض , --٢٥٩١ , طريق الدمام
            $table->text('business_description_english')->nullable(); // Al Yarmouk 8194
            $table->text('business_description_arabic')->nullable(); // حي اليرموك , ٨١٩٤

            // Invoice Settings
            $table->string('invoice_side_arabic')->nullable();        // From form
            $table->string('invoice_side_english')->nullable();       // From form
            $table->string('english_description')->nullable();        // AL RAJHI BANK IBANSA
            $table->string('arabic_description')->nullable();         // Email/Site info
            $table->decimal('vat_percentage', 5, 2)->nullable();      // 15
            $table->string('apply_discount_type')->nullable();        // Before
            $table->string('language')->nullable();                   // english
            $table->boolean('show_email_on_invoice')->default(false); // No

            // Website Information
            $table->string('website')->nullable();                    // From existing migration

            // Banking Information
            $table->string('bank_name')->nullable();                  // From existing migration
            $table->string('iban', 50)->nullable();                  // From existing migration

            // Type Information
            $table->string('company_type')->default('customer');     // customer/vendor

            // New Fields for File Uploads
            $table->string('company_logo')->nullable();              // Path to company logo
            $table->string('company_stamp')->nullable();             // Path to company stamp

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
        Schema::dropIfExists('companies');
    }
};
