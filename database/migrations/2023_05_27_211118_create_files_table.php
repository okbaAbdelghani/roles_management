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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('file_path')->nullable();
            $table->string('status')->nullable();
            $table->integer('progress')->nullable();
            $table->integer('nb_of_lines')->nullable();
            $table->string('size')->nullable();
            $table->integer('tries')->default(0);
            $table->longText('last_error')->nullable();
            $table->json('file_columns')->nullable();
            $table->string('table_name')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->json('columns_in_table')->nullable();
            $table->boolean('erase_table')->default(false);
            $table->string('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
