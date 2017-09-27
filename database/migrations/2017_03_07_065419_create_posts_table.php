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
                $table->integer('category_id')->unsigned()->default(0);
                $table->integer('user_id')->unsigned()->default(0);
                $table->integer('last_user_id')->unsigned()->default(0);
                $table->string('title')->default('');
                $table->string('slug')->unique()->default('');
                $table->text('description')->nullable();
                $table->text('content')->nullable();
                $table->string('cover_img')->nullable();
                $table->string('tag')->nullable();
                $table->string('recommend')->nullable();
                $table->integer('view_count')->unsigned()->default(0);
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
