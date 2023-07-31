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
        Schema::create('manuscripts', function (Blueprint $table) {
            $table->id();
            $table->uuid()->nullable();
            $table->text('autherName')->nullable();
            $table->text('title')->nullable();
            $table->text('class')->nullable();
            $table->text('lib')->nullable();
            $table->text('dis')->nullable();
            $table->text('lang')->nullable();
            $table->text('countery')->nullable();
            $table->text('firstNum')->nullable();
            $table->text('secondNum')->nullable();
            $table->text('copyName')->nullable();
            $table->text('copyDate')->nullable();
            $table->text('first')->nullable();
            $table->text('last')->nullable();
            $table->text('paperNum')->nullable();
            $table->text('font')->nullable();
            $table->text('ink')->nullable();
            $table->text('pageSize')->nullable();
            $table->text('textArea')->nullable();
            $table->text('linesNum')->nullable();
            $table->text('textStatus')->nullable();
            $table->text('notes')->nullable();
            $table->text('source')->nullable();
            $table->text('convertTitle')->nullable();
            $table->text('city')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manuscripts');
    }
};
