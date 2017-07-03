<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLastVisitedUseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visited_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('last_visited');
            $table->string('browsers')->nullable();
            $table->string('local')->nullable();
            $table->string('ip')->nullable();
            $table->text('operated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visited_user', function (Blueprint $table) {
            $table->dropForeign('visited_user_user_id_foreign');
         });
        Schema::dropIfExists('visited_user');
    }
}
