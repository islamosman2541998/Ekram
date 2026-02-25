<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   
public function up()
{
    Schema::table('category_projects', function (Blueprint $table) {
        if (!Schema::hasColumn('category_projects', 'cashier_system')) {
            $table->boolean('cashier_system')->default(0)->after('fast_donation');
        }
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_projects', function (Blueprint $table) {
            //
        });
    }
};
