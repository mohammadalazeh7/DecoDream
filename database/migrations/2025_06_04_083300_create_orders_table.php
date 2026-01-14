<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['submitted', 'preparing', 'on_shipping', 'delivered', 'cancelled'])->default('submitted');
            $table->foreignId("user_id")->references("id")->on("users");
            $table->boolean("shipping_required");
            $table->string("location")->nullable();
            $table->string("phone_number");
            $table->enum('payment_method', ['online_prepayment', 'pay_on_pickup']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
