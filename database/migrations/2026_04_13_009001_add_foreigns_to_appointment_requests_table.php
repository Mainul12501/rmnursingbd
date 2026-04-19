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
        Schema::table('appointment_requests', function (Blueprint $table) {
            $table
                ->foreign('requested_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('managed_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('company_service_id')
                ->references('id')
                ->on('company_services')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointment_requests', function (Blueprint $table) {
            $table->dropForeign(['requested_user_id']);
            $table->dropForeign(['managed_user_id']);
            $table->dropForeign(['company_service_id']);
        });
    }
};
