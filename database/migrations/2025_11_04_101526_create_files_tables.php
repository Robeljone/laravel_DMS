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
        Schema::create('files_tables', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('extension');
            $table->foreignId('dire_id');
            $table->string('dire_path');
            $table->integer('status')->default(1); 
            $table->foreignId('cuid');
            $table->timestamps();
        });
        Schema::create('file_tags', function (Blueprint $table) {
         $table->id();
         $table->string('name');
         $table->integer('status'); 
         $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files_tables');
        Schema::dropIfExists('file_tags');
    }
};
