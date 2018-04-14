<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->longtext('description')->nullable();
            $table->longtext('content')->nullable();
            $table->string('location_id')->nullable();
            $table->string('listing_type_id')->nullable();
            $table->string('image')->nullable();
            $table->string('featured')->default('NO');
            $table->string('web_visible')->default('YES');
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
        Schema::dropIfExists('listings');
    }
}
