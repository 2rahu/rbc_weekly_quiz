<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('questions_by_editor', function (Blueprint $table) {
            $table->id('ques_id');
            $table->unsignedBigInteger('topic_id');
            $table->foreign('topic_id')->references('topic_id')->on('quiz_topics');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->text('question')->nullable();
            $table->string('filePath')->nullable();
            $table->text('option_1');
            $table->text('option_2');
            $table->text('option_3');
            $table->text('option_4');
            $table->text('answers');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }




  
    public function down(): void
    {
        Schema::dropIfExists('questions_by_editor');
    }
};
