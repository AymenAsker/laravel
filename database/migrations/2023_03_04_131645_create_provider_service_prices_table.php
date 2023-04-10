<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_service_prices', function (Blueprint $table) {
            $table->foreignId('provider_service_id')->constrained('provider_services','id')->cascadeOnDelete();
            $table->string('price_name')->nullable();
            $table->string('price_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_service_prices');
    }
};
