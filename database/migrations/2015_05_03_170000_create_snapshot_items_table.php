<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSnapshotItemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snapshot_items', function($table)
        {
            $table->increments('id');

            $table->unsignedInteger('snapshot_id');
            $table->string('file');
            $table->unsignedInteger('line');
            $table->string('function', 60);
            $table->string('class', 128);
            $table->mediumText('object');
            $table->string('type', 50);
            $table->mediumText('args');

            $table->foreign('snapshot_id')->references('id')->on('snapshots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('snapshot_items');
    }

}
