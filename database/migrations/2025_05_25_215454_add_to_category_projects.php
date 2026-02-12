<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('category_projects', function (Blueprint $table) {
            $table->string('statistics')->nullable();
        });
    }

    public function down()
    {
        Schema::table('category_projects', function (Blueprint $table) {
            $table->dropColumn('cashier_system');
        });
    }
};