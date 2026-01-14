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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->double("price");
            $table->string("name");
            $table->string("description");
            $table->integer("available_quantity");
            $table->foreignId("category_id")->references("id")->on("categories");
            $table->foreignId("color_id")->nullable()->references("id")->on("colors");
            $table->foreignId('fabric_id')->nullable()->references('id')->on('fabrics');
            $table->foreignId('wood_id')->nullable()->references('id')->on('woods');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
