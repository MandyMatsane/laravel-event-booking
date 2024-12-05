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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('location');
            $table->dateTime('date_time');
            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreignId('organizer_id')->constrained('users');
            $table->integer('max_attendees');
            $table->decimal('ticket_price', 8, 2);
            $table->enum('status', ['Upcoming', 'Ongoing', 'Completed']);
            $table->enum('visibility', ['Public', 'Private']);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
