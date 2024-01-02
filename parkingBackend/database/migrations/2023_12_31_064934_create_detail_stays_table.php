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
        Schema::create('detail_stays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->nullable()->constrained();
            $table->string('license_plate', 10);
            $table->time('check_in_time');
            $table->time('check_out_time')->nullable();
            $table->decimal('payment_amount',12,2)->nullable()->comment('fee per total minutes');
            $table->unsignedBigInteger('total_stay_minutes')->nullable()->comment('counter minutes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_stays');
    }
};
