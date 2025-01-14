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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('ibr_no')->nullable()->unique();
            $table->foreignId('referred_by')->nullable()
                ->constrained('users', 'id')
                ->onDelete('set null');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->enum('gender',['Male','Female','Other'])->nullable();
            $table->string('country_of_business')->nullable();
            $table->string('city_of_business')->nullable();
            $table->string('country_of_bank')->nullable();
            $table->string('bank')->nullable();
            $table->string('iban')->nullable();
            $table->string('currency')->nullable();
            $table->string('mobile_number')->nullable();
            $table->date('dob')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('device_name')->nullable();
            $table->enum('type',['Super Admin','Admin Support','Admin','Team Member','IBR'])->default('Admin');
            $table->enum('is_active',['Yes','No'])->nullable();
            $table->enum('is_super_admin',['Yes','No'])->default('No')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
