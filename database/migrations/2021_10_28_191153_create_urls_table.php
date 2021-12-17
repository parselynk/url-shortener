<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urls', function (Blueprint $table) {
            $table->id();
            $table->string('shortcode_uuid', 5)->unique();
            $table->string('redirect_url', 500);
            $table->bigInteger('hit_count')->unsigned()->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->unique('redirect_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urls');
    }
}
