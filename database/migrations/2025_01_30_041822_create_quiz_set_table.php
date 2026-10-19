<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('quiz_set', function (Blueprint $table) {
            $table->id('quiz_set_id');
            $table->date('quiz_launch_date');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_set');
    }
};
