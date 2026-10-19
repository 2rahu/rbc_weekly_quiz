<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id('question_id');

            $table->unsignedBigInteger('quiz_set_id');
            $table->foreign('quiz_set_id')
            ->references('quiz_set_id')
            ->on('quiz_set')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('ques_id');
            $table->foreign('ques_id')
            ->references('ques_id')
            ->on('questions_by_editor');



            $table->unsignedBigInteger('topic_id');
            $table->foreign('topic_id')->references('topic_id')->on('quiz_topics');


            $table->text('question')->nullable();
            $table->string('filePath')->nullable();
            $table->text('option_1');
            $table->text('option_2');
            $table->text('option_3');
            $table->text('option_4');
            $table->text('answer');
            $table->boolean('is_running')->default(false);
            $table->string('status')->default('active');

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
