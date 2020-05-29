<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoushinYoyakuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soushin_yoyaku', function (Blueprint $table) {
            $table->id();
            $table->integer('chiken_id');
            $table->integer('chiken_sub_id');
            $table->integer('question_template_id');
            $table->string('question_url')->nullable();
            $table->string('question_result_url')->nullable();
            $table->dateTime('soushin_yoyaku_dtt');
            $table->dateTime('soushin_dtt')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->unique(['chiken_id', 'chiken_sub_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soushin_yoyaku');
    }
}
