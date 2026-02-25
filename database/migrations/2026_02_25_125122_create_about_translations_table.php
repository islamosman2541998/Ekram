<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('about_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('about_id');
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('mission_title')->nullable();
            $table->text('mission_description')->nullable();
            $table->string('vision_title')->nullable();
            $table->text('vision_description')->nullable();
            $table->string('values_title')->nullable();
            $table->text('values_description')->nullable();
            $table->timestamps();

            $table->unique(['about_id', 'locale']);
            $table->foreign('about_id')->references('id')->on('abouts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('about_translations');
    }
};