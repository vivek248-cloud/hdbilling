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
    Schema::table('projects', function (Blueprint $table) {
        $table->decimal('gst', 5, 2)->default(18)->after('budget'); // GST percentage (e.g., 18.00)
        $table->decimal('discount', 10, 2)->default(0)->after('gst'); // Discount amount in ₹
    });
}

public function down(): void
{
    Schema::table('projects', function (Blueprint $table) {
        $table->dropColumn(['gst', 'discount']);
    });
}

};
