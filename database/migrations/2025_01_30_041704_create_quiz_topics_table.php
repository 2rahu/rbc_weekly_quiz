<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('quiz_topics', function (Blueprint $table) {
            $table->id('topic_id');
            $table->string('topic_name');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('quiz_topics');
    }
};
