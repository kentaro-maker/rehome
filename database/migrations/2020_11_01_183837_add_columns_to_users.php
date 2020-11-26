<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
          $table->string('gender')->nullable();
          $table->date('bod')->nullable();
          $table->string('birthplace')->nullable();
          $table->string('residence')->nullable();
          $table->string('marriage_status')->nullable();
          $table->string('occupation')->nullable();
          $table->string('annual_income')->nullable();
          $table->string('household_composition')->nullable();
          $table->string('living_style')->nullable();
          $table->string('commuting_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('gender');
          $table->dropColumn('bod');
          $table->dropColumn('birthplace');
          $table->dropColumn('residence');
          $table->dropColumn('marriage_status');
          $table->dropColumn('occupation');
          $table->dropColumn('annual_income');
          $table->dropColumn('household_composition');
          $table->dropColumn('living_style');
          $table->dropColumn('commuting_time');
        });
    }
}
