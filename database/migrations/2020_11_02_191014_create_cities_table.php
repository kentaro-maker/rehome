<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('image_path')->nullable();
            $table->string('prefecture')->nullable();
            $table->string('region')->nullable();

            $table->integer('pop')->nullable();
            $table->integer('land')->nullable();
            $table->integer('jp')->nullable();
            $table->integer('household')->nullable();
            $table->integer('yo_school')->nullable();
            $table->integer('sho_school')->nullable();
            $table->integer('chu_school')->nullable();
            $table->integer('ko_school')->nullable();
            $table->integer('empty')->nullable();
            $table->integer('kominkan')->nullable();
            $table->integer('toshokan')->nullable();
            $table->integer('forest')->nullable();
            $table->string('portal')->nullable();
            $table->integer('hospital')->nullable();
            $table->integer('clinic')->nullable();

            $table->string('investigated_at')->nullable();
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
        Schema::dropIfExists('cities');
    }
}
