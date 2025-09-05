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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('status_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('severity_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('developer_id')->nullable()->constrained('users')->cascadeOnUpdate();
            $table->date('start_date');
            $table->date('due_date');
            $table->date('finish_date')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
