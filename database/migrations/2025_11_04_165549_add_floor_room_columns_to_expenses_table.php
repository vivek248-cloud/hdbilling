<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {

            if (!Schema::hasColumn('expenses', 'group')) {
                $table->unsignedBigInteger('group')->nullable()->after('description');
            }

            if (!Schema::hasColumn('expenses', 'group2')) {
                $table->unsignedBigInteger('group2')->nullable()->after('group');
            }
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {

            if (Schema::hasColumn('expenses', 'group')) {
                $table->dropColumn('group');
            }

            if (Schema::hasColumn('expenses', 'group2')) {
                $table->dropColumn('group2');
            }
        });
    }
};
