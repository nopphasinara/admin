<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleHasPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('role_has_permissions', function (Blueprint $table) {
          $table->integer('permission_id')->unsigned();
          $table->integer('role_id')->unsigned();

          $table->foreign('permission_id')
              ->references('id')
              ->on('permissions')
              ->onDelete('cascade');

          $table->foreign('role_id')
              ->references('id')
              ->on('roles')
              ->onDelete('cascade');

          $table->primary(['permission_id', 'role_id']);

          app('cache')->forget('spatie.permission.cache');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_has_permissions');
    }
}
