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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->array('finished_lessons');
            $table->array('finished_sections');

            $table->foreignId('user_id')->constrained();
            $table->foreignId('course_id')->constrained();

            $table->boolean('is_valid')->default(true);
            $table->boolean('is_finished')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
};
