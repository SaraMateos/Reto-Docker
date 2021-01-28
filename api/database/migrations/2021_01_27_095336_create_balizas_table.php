<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalizasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balizas', function (Blueprint $table) {
            $table->id();
            $table->string("nombre")->unique();
            $table->string("municipio");
            $table->string("provincia");
            $table->string("latitud");
            $table->string("longitud");
            $table->string("altitud");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balizas');
    }
}
