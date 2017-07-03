<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
           $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->string('description')->nullable();
            $table->integer('format')->default(0); // 0: normal | 1: audio | 2: image | 3: video
            $table->text('content')->nullable(); // 
             // mp3 JSON [{"title": "lorem ispum dolor sit amet", "url":"http:/sfghsdghsdsgs.mp3", "lyric": "lời bài hát thật hay lắm"}, {"title": "lorem ispum dolor sit amet", "url":"http:/sfghsdghsdsgs.mp3", "lyric": "lời bài hát thật hay lắm"}]
             // image JSON [{"title": "lorem ispum dolor sit amet", "url":"http:/sfghsdghsdsgs.mp3", "alt":"dfdfhkdfhdfjhdjfh"}, {"title": "lorem ispum dolor sit amet", "url":"http:/sfghsdghsdsgs.mp3", "alt":"dfdfhkdfhdfjhdjfh"}]
            $table->string('thumbnail')->nullable();
            $table->integer('opencomment')->default(1); //0: close comment | 1:open comment
            $table->integer('openedit')->default(0); // Allow another user change article - 0: close edit | 1:open edit
            $table->integer('notify')->default(0); // Recieve notify from article when another user comment, change in this article
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
        Schema::dropIfExists('articles');
    }
}
