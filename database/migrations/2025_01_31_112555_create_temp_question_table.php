<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('temp_question', function (Blueprint $table) {
            $table->id('ques_id');
            $table->unsignedBigInteger('topic_id');
            $table->foreign('topic_id')->references('topic_id')->on('quiz_topics');
            $table->text('question')->nullable();
            $table->string('filePath')->nullable();
            $table->text('option_1');
            $table->text('option_2');
            $table->text('option_3');
            $table->text('option_4');
            $table->text('ansers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_question');
    }
};
