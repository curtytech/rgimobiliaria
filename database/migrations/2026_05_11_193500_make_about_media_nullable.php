<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about', function (Blueprint $table) {
            $table->string('logo')->nullable()->change();
            $table->string('banner')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('about', function (Blueprint $table) {
            $table->string('logo')->nullable(false)->change();
            $table->string('banner')->nullable(false)->change();
        });
    }
};
