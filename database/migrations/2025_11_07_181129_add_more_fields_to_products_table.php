<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ Only modify 'products' table now (no duplicate creation)
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'full_semi_id')) {
                $table->foreignId('full_semi_id')->nullable()->constrained('full_semi_types')->onDelete('set null');
            }
            if (!Schema::hasColumn('products', 'core_material')) {
                $table->string('core_material')->nullable();
            }
            if (!Schema::hasColumn('products', 'finish_material')) {
                $table->string('finish_material')->nullable();
            }
            if (!Schema::hasColumn('products', 'brand')) {
                $table->string('brand')->nullable();
            }
            if (!Schema::hasColumn('products', 'price')) {
                $table->decimal('price', 10, 2)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['full_semi_id']);
            $table->dropColumn(['full_semi_id', 'core_material', 'finish_material', 'brand', 'price']);
        });
    }
};
