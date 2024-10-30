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
        Schema::table('users', function (Blueprint $table) {
            $table->string('name', 60)->change();
            $table->string('photo');
            $table->string('phone');
            $table->unsignedBigInteger('position_id');

            $table->foreign('position_id')->references('id')->on('positions')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->change();
            $table->dropForeign(['position_id']);
            $table->dropColumn(['phone', 'photo', 'position_id']);
        });
    }
};
