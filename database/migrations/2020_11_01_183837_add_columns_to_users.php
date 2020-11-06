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
          $table->string('gender');
          $table->string('age');
          $table->string('birthplace');
          $table->string('residence');
          $table->string('marriage_status');
          $table->string('occupation');
          $table->string('annual_income');
          $table->string('household_composition');
          $table->string('living_style');
          $table->string('commuting_time');
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
          $table->dropColumn('age');
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
