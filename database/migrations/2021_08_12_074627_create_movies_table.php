<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('imdb_id')->unique();
            $table->string('name');
            $table->string('url')->unique();
            $table->text('image');
            $table->float('rating');
            $table->integer('metascore')->nullable();
            $table->text('synopsis');
            $table->text('genre');
            $table->integer('lenght');
            $table->integer('release_year');
            $table->string('directors');
            $table->text('stars');
            /* $table->timestamps(); */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
