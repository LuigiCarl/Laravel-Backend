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
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();

            $table->foreignId('book_id')
                ->constrained()
                ->onDelete('cascade')
                ->comment('Reference to the borrowed book');

            $table->foreignId('borrower_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->comment('Reference to the user who borrowed');

            $table->dateTime('borrow_date')->comment('Date and time when the book was borrowed');
            $table->dateTime('due_date')->comment('Due date for return');
            $table->dateTime('return_date')->nullable()->comment('Actual date the book was returned');

            $table->enum('status', ['active', 'returned'])->default('active')->index()->comment('Current borrow status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
