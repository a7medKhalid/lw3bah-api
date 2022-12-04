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
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title')->nullable();
            $table->string('body')->nullable();
            $table->string('type');
            $table->string('question_type')->nullable();
            $table->string('content_type')->nullable();

            $table->integer('order')->default(1);

            $table->foreignId('lesson_id')->constrained();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slides');
    }
};
