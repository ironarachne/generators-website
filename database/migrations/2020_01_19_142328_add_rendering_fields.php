<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRenderingFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cultures', function (Blueprint $table) {
            $table->string('name')->default('');
            $table->string('description')->default('');
            $table->text('html');
        });

        Schema::table('regions', function (Blueprint $table) {
            $table->string('name')->default('');
            $table->string('description')->default('');
            $table->text('html');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cultures', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('description');
            $table->dropColumn('html');
        });

        Schema::table('regions', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('description');
            $table->dropColumn('html');
        });
    }
}
