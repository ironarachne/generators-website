<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToRegions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->index('created_at', 'ix_created');
            $table->index(['user_id', 'created_at'], 'ix_user_created');
            $table->index('user_id', 'ix_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->dropIndex('ix_created');
            $table->dropIndex('ix_user_created');
            $table->dropIndex('ix_user');
        });
    }
}
