<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfiguracionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracions', function (Blueprint $table) {
            $table->id();
            $table->string('twilio_sid')->nullable();
            $table->string('twilio_token')->nullable();
            $table->string('twilio_from')->nullable();
            $table->string('twilio_to_default')->nullable();
            $table->timestamps();
        });

        // Insert default values (Placeholders)
        DB::table('configuracions')->insert([
            'twilio_sid' => null,
            'twilio_token' => null,
            'twilio_from' => null,
            'twilio_to_default' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuracions');
    }
}
