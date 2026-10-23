<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('temp_question', function (Blueprint $table) {
            $table->renameColumn('ansers', 'answers');
        });
    }

    public function down(): void
    {
        Schema::table('temp_question', function (Blueprint $table) {
            $table->renameColumn('answers', 'ansers');
        });
    }
};