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
        Schema::create('volumes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->unsignedBigInteger('author_id');
            $table->timestamps();
            $table->dateTime('published_at')->nullable();
            $table->boolean('published')->nullable(false);
            $table->foreign('author_id')->references('id')->on('users')->onDelete(null)->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volumes');
    }
};
