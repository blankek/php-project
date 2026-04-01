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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // заголовок
            $table->text('content'); // текст новости
            $table->string('status')->default('draft'); // статус: draft, published и т.д.
            $table->timestamp('published_at')->nullable(); // дата публикации
            $table->integer('likes')->default(0); // лайки
            $table->integer('comments')->default(0); // комментарии
            $table->string('picture')->nullable(); // путь к картинке
            $table->timestamps(); // created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};  