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
        Schema::create('delivery_notes', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_number')->unique();
            $table->foreignId('quotation_id')->nullable()->constrained();
            $table->foreignId('company_id')->constrained();
            $table->foreignId('created_by')->constrained('users');
            $table->string('po_number')->nullable();
            $table->date('delivery_date');
            $table->string('delivery_status')->default('pending'); // pending/delivered/rejected
            $table->foreignId('received_by')->nullable()->constrained('contacts');
            $table->foreignId('delivered_by')->nullable()->constrained('contacts');
            $table->date('received_date')->nullable();
            $table->string('receiving_signature')->nullable();
            $table->string('delivering_signature')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_notes');
    }
};
