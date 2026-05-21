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
        Schema::create('about', function (Blueprint $table) {
            $table->id();
            $table->string('enterprise_name');
            $table->string('description');
            $table->string('contact');
            $table->string('email');
            $table->string('phone');
            $table->string('address')->nullable();
            $table->string('city');->nullable();
            $table->string('state');->nullable();
            $table->string('zip');->nullable();
            $table->string('country');->nullable();
            $table->string('logo');->nullable();
            $table->string('banner')->nullable();
            $table->string('video_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about');
    }
};
