<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->enum('status', ['pending', 'confirmed', 'processing', 'completed', 'cancelled'])->default('pending')->after('quantity');
            $table->timestamp('confirmed_at')->nullable()->after('status');
            $table->timestamp('processing_at')->nullable()->after('confirmed_at');
            $table->timestamp('completed_at')->nullable()->after('processing_at');
            $table->timestamp('cancelled_at')->nullable()->after('completed_at');
        });
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['status', 'confirmed_at', 'processing_at', 'completed_at', 'cancelled_at']);
        });
    }
};
