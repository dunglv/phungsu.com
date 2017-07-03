<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActiveUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('type_active')->default('email'); //email, phone
            $table->text('key')->nullable(); //"{"type":"email", key":"xoBN57Gt", "expire":"10/10/2017 10:10:10"}"
            $table->integer('active')->default(0);
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
        Schema::table('active_user', function (Blueprint $table) {
            $table->dropForeign('active_user_user_id_foreign');
         });
        Schema::dropIfExists('active_user');
    }
}
