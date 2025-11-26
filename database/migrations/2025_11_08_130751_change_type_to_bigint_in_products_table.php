<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Only run if the 'type' column exists
            if (Schema::hasColumn('products', 'type')) {
                $table->unsignedBigInteger('type')->nullable()->change();
                $table->foreign('type')->references('id')->on('full_semi_types')->onDelete('set null');
            } else {
                // If it doesn't exist, create it cleanly
                $table->unsignedBigInteger('type')->nullable()->after('price');
                $table->foreign('type')->references('id')->on('full_semi_types')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'type')) {
                $table->dropForeign(['type']);
                $table->dropColumn('type');
            }
        });
    }
};
