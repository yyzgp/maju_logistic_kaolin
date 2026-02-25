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
            $table->unsignedBigInteger('parent_task_id')->nullable();
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->string('type')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('iso2')->nullable();
            $table->string('dialcode')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->text('location')->nullable();
            $table->timestamp('due_time')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('registration_number')->nullable();

            $table->string('destination_contact_name')->nullable();
            $table->string('destination_contact_email')->nullable();
            $table->string('destination_dialcode')->nullable();
            $table->string('destination_phone')->nullable();
            $table->text('destination_address')->nullable();
            $table->text('destination_building_floor_room')->nullable();
            $table->double('destination_latitude')->nullable();
            $table->double('destination_longitude')->nullable();
            $table->text('destination_notes')->nullable();
            $table->string('destination_iso2')->nullable();

            $table->string('priority')->nullable();
            $table->decimal('due_amount', 10, 2)->default(0);
            $table->decimal('towing_fee', 10, 2)->default(0);
            $table->enum('status', ['active','in-transist','arrived', 'completed', 'cancelled', 'failed'])->default('active');
            $table->text('requirements')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('arrival_time')->nullable();
            $table->timestamp('completion_time')->nullable();
            $table->longText('signature')->nullable();
            $table->longText('driver_notes')->nullable();
            $table->unsignedBigInteger('service_time')->nullable();
            $table->unsignedBigInteger('added_by_id')->nullable();
            $table->foreign('added_by_id')->references('id')->on('administrators')->onDelete('cascade');
            $table->unsignedBigInteger('dispatched_by_id')->nullable();
            $table->foreign('dispatched_by_id')->references('id')->on('administrators')->onDelete('cascade');
            $table->boolean('invoice_generated')->default(0);
            $table->boolean('do_sent')->default(0);
            $table->string('invoice_no')->nullable();
            $table->text('remarks')->nullable();
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
