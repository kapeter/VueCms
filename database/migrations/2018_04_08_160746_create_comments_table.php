<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('comment_type');
            $table->integer('comment_relation_id');
            $table->string('comment_author');
            $table->string('comment_author_email');
            $table->string('comment_author_url')->nullable();
            $table->string('comment_author_ip');
            $table->string('comment_content');
            $table->integer('comment_parent_id')->default(0);
            $table->boolean('comment_status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
