<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string( 'guid', 128 )->unique();
            $table->string('name');
            $table->string('adjective');
            $table->string('description')->nullable();
            $table->string('descriptors')->nullable();
            $table->string('sample_phrase')->nullable();
            $table->string('sample_phrase_translation')->nullable();
            $table->boolean('is_tonal')->default(false);
            $table->string('new_word_prefixes')->nullable();
            $table->string('new_word_suffixes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
