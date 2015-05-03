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
            $table->string('file')->nullable()->default(null);
            $table->unsignedInteger('line')->nullable()->default(null);
            $table->string('function', 60)->nullable()->default(null);
            $table->string('class', 128)->nullable()->default(null);
            $table->mediumText('object')->nullable()->default(null);
            $table->string('type', 50)->nullable()->default(null);
            $table->mediumText('args')->nullable()->default(null);

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
