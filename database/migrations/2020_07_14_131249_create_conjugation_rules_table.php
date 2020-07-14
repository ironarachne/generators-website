<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConjugationRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conjugation_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger( 'language_id' )->index();
            $table->string('for_gender');
            $table->string('for_speech_part');
            $table->string('for_plural_type');
            $table->string('for_tense');
            $table->string('affix_type');
            $table->string('affix');
            $table->tinyInteger('replace_characters')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conjugation_rules');
    }
}
