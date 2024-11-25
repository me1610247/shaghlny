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
        Schema::create('job', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // To associate with the user who posted the job
            $table->string('title');
            $table->text('description');
            $table->string('location')->nullable(); // Optional location for the job
            $table->enum('job_type', ['Full-time', 'Part-time', 'Contract'])->default('Full-time');
            $table->decimal('salary', 10, 2)->nullable(); // Optional salary
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job');
    }
};
