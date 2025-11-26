<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ Only create if not already exists
        if (!Schema::hasTable('full_semi_types')) {
            Schema::create('full_semi_types', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // Full or Semi
                $table->decimal('rate', 10, 2); // rate per sqft/m²
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('full_semi_types');
    }
};
