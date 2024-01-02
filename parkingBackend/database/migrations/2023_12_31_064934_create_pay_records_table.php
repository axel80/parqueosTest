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
        Schema::create('pay_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->nullable()->constrained();
            $table->string('license_plate', 10);
            $table->unsignedBigInteger('total_stay_minutes')->comment('counter minutes');
            $table->decimal('total_stay_payment', 12, 2);
            $table->dateTime('date_time_payment');
            $table->dateTime('period_start')->comment('date time start');
            $table->dateTime('period_end')->comment('date time end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_records');
    }
};
