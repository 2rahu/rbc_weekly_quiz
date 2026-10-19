<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id('role_id');
            $table->string('role');
            $table->timestamps();
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
