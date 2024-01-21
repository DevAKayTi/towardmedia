<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('type_id');
            $table->string('title')->nullable(false);
            $table->string('slug')->nullable(false);
            $table->text('content', 2000)->nullable(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->boolean('published')->nullable(false);
            $table->dateTime('published_at')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->onDelete(null)->onUpdate('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete(null)->onUpdate('cascade');
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
        Schema::dropIfExists('posts');
    }
};
