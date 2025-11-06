<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {

            // convert group → floor type id (unsigned BigInt)
            $table->unsignedBigInteger('group')->nullable()->change();

            // convert group2 → room type id (unsigned BigInt)
            $table->unsignedBigInteger('group2')->nullable()->change();

            // add foreign keys
            $table->foreign('group')->references('id')->on('floor_types')->onDelete('cascade');
            $table->foreign('group2')->references('id')->on('room_types')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['group']);
            $table->dropForeign(['group2']);
        });
    }
};
