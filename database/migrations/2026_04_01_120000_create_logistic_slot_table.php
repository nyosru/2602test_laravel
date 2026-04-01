<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slot', function (Blueprint $table) {
            $table->unsignedInteger('slot_id')->primary();
            $table->unsignedInteger('capacity');
            $table->unsignedInteger('remaining');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slot');
    }
};
