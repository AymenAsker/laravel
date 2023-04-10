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
        Schema::create('provider_services', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->foreignId("provider_id")->constrained('providers','id')->cascadeOnDelete();
            $table->foreignId("service_id")->constrained('services','id');
            $table->string('name_brand');
            $table->string('day_of_week');
            $table->string('start_time');
            $table->string('end_time');
            $table->text('details');
            $table->boolean('status')->default(1);
            $table->boolean('status_a')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_services');
    }
};
