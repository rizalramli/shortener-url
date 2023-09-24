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
        Schema::create('shortener_url', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade');
            $table->string('slug');
            $table->text('url_destination');
            $table->text('url_short');
            $table->integer('visitors')->default(0);
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->text('link_image_offline')->nullable();
            $table->text('link_image_online')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shortener_url');
    }
};
