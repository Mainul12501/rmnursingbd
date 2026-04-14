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
        Schema::create('company_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('content_title')->nullable();
            $table->longText('page_content')->nullable();
            $table->string('page_main_image')->nullable();
            $table
                ->enum('service_menu_type', ['main', 'sub', 'both'])
                ->default('main');
            $table
                ->tinyInteger('status')
                ->default(1)
                ->nullable();
            $table->text('page_sub_images')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('slug')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_services');
    }
};
