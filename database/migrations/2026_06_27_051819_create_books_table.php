<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('isbn')->unique();

            $table->foreignId('category_id')
                ->constrained()
                ->restrictOnDelete();

            $table->unsignedInteger('total_copies');
            $table->unsignedInteger('available_copies');

            $table->timestamps();
            $table->softDeletes();

            $table->index([
                'category_id',
                'available_copies',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};