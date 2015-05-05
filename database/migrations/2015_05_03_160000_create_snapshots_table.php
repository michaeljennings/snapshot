<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSnapshotsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snapshots', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('file')->nullable()->default(null);
            $table->string('line', 12)->nullable()->default(null);
            $table->text('message')->nullable()->default(null);
            $table->unsignedInteger('code')->nullable()->default(null);
            $table->mediumText('server')->nullable()->default(null);
            $table->mediumText('post')->nullable()->default(null);
            $table->mediumText('get')->nullable()->default(null);
            $table->mediumText('files')->nullable()->default(null);
            $table->mediumText('cookies')->nullable()->default(null);
            $table->mediumText('session')->nullable()->default(null);
            $table->mediumText('environment')->nullable()->default(null);
            $table->mediumText('additional_data')->nullable()->default(null);

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
        Schema::drop('snapshots');
    }

}
