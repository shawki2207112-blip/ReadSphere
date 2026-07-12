<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('book_id')
                ->constrained()
                ->restrictOnDelete();

            $table->date('issue_date');
            $table->date('due_date');
            $table->date('returned_at')->nullable();

            $table->string('status')
                ->default('borrowed')
                ->index();

            $table->timestamps();

            $table->index([
                'user_id',
                'status',
            ]);

            $table->index([
                'book_id',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};