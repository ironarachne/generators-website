<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeraldriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'heraldries', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->timestamps();
            $table->unsignedBigInteger( 'user_id' )->nullable();
            $table->string( 'guid', 128 )->unique();
            $table->string( 'url', 128 )->unique();
            $table->string( 'blazon', 255 );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'heraldries' );
    }
}
