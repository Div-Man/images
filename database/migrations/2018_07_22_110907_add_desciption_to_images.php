<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDesciptionToImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('images', function($table) {
        $table->string('description');
    });
}

public function down()
{
    Schema::table('images', function($table) {
        $table->dropColumn('description');
    });
}
}
