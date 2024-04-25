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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId("order_id")->nullable()->constrained()->nullOnDelete()->onUpdate("SET NULL");
            $table->string("name");
            $table->unsignedInteger("count")->default(1);
            $table->decimal("cost", 10)->unsigned();
            $table->decimal("vat", 4)->unsigned()->nullable();
            $table->decimal("cost_with_vat", 10)->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
