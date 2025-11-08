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
        Schema::create('ttd_reminder_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('user_email');
            $table->string('user_name');
            $table->boolean('is_intensive')->default(false)->comment('Intensive reminder for menstruating users');
            $table->enum('status', ['sent', 'skipped', 'disabled'])->default('sent');
            $table->text('reason')->nullable()->comment('Reason for skipped or disabled');
            $table->date('reminder_date');
            $table->timestamps();

            $table->index('user_id');
            $table->index('reminder_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ttd_reminder_logs');
    }
};
