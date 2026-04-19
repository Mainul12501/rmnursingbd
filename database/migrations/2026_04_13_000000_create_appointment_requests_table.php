<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointment_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('requested_user_id')->nullable();
            $table->string('name');
            $table->string('mobile');
            $table->string('email');
            $table->string('subject');
            $table->text('message');
            $table
                ->enum('status', [
                    'pending',
                    'contacted',
                    'scheduled',
                    'rejected',
                    'solved',
                ])
                ->default('pending')
                ->nullable();
            $table->unsignedBigInteger('managed_user_id')->nullable();
            $table->unsignedBigInteger('company_service_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_requests');
    }
};
