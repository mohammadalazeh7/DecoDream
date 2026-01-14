<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('order_id')->references('id')->on('orders');
            $table->foreignId('employee_id')->nullable()->references('id')->on('employees');
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->string("card_number")->nullable();
            $table->string("card_code")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
