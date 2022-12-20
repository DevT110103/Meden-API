<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGaleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galeries', function (Blueprint $table) {
            $table->id();
            if (env('APP_ENV') == 'local') {
                $table->longText('thumbnail')->default(env('APP_URL') . ':' . env('APP_PORT') . '/uploads/err.png');
            } else {
                $table->longText('thumbnail')->default(env('APP_URL') . '/uploads/err.png');
            }
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
        Schema::dropIfExists('galeries');
    }
}
