<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title')->require();
            $table->string('sub_title');
            if (env('APP_ENV') == 'local') {
                $table->longText('thumbnail')->default(env('APP_URL') . ':' . env('APP_PORT') . '/uploads/err.png');
            } else {
                $table->longText('thumbnail')->default(env('APP_URL') . '/uploads/err.png');
            }
            $table->longText('desc');
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
        Schema::dropIfExists('contents');
    }
}
