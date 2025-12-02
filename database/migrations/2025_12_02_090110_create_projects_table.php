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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('registration_id')->unique()->nullable();
            $table->string('mda')->nullable();
            $table->string('sector')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('cost', 15, 2)->nullable();
            $table->string('objective')->nullable();
            $table->string('location')->nullable();
            $table->string('phase')->nullable();
            $table->string('status')->default('draft');
            $table->date('expected_start')->nullable();
            $table->date('expected_end')->nullable();
            $table->date('date_of_submission')->nullable();
            $table->date('date_of_entry')->nullable();
            $table->json('attachments')->nullable();
            $table->text('comments')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->index(['mda', 'sector', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
