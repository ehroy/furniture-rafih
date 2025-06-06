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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('sub_category_id');
            $table->string('slug');
            $table->string('name');
            $table->string('code_sku')->unique();
            $table->integer('width');
            $table->integer('depth');
            $table->integer('height');
            $table->json('image')->default(json_encode([]));
            $table->longText('content');
            $table->integer('price')->default(0);
            $table->integer('views')->default(0);
            $table->boolean('recomended')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
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
