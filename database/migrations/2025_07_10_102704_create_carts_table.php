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
        Schema::create('carts', function (Blueprint $table) {
           $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2); // Price at time of adding to cart
            $table->decimal('total_price', 10, 2); // quantity * unit_price
            $table->enum('status', ['active', 'ordered', 'saved_for_later'])->default('active');
            $table->timestamps();
            
            // Composite unique key to prevent duplicate entries
            $table->unique(['user_id', 'book_id', 'status']);
            
            // Indexes
            $table->index(['user_id', 'status']);
            $table->index('book_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
