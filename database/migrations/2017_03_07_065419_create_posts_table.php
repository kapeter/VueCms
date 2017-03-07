<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( !Schema::hasTable('posts') ){
            Schema::create('posts', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('category_id')->unsigned();
                $table->integer('user_id')->unsigned();
                $table->integer('last_user_id')->unsigned();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('description');
                $table->text('content');
                $table->string('cover_img')->nullable();
                $table->string('tag')->nullable();
                $table->string('is_draft')->default(false);
                $table->integer('view_count')->unsigned()->default(0)->index();
                $table->timestamp('published_at')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });        
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
