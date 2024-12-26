<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('chronicle');
            $table->integer('intelligence')->default(10);
            $table->integer('charisma')->default(10);
            $table->integer('wisdom')->default(10);
            $table->integer('strength')->default(10);
            $table->integer('dexterity')->default(10);
            $table->integer('constitution')->default(10);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
