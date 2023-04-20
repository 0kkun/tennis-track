<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->comment('テニス選手管理テーブル');
            $table->id();
            $table->string('name_jp', 100)->nullable()->comment('選手名(和)');
            $table->string('name_en', 100)->nullable()->comment('選手名(英)');
            $table->string('country', 100)->nullable()->comment('出身');
            $table->date('birthday')->nullable()->comment('生年月日');
            $table->unsignedTinyInteger('gender')->nullable()->comment('性別[0:男/1:女]');
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
        Schema::dropIfExists('players');
    }
};
