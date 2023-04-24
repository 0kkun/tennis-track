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
        Schema::create('tennis_atp_rankings', function (Blueprint $table) {
            $table->comment('テニスのATPランキング管理テーブル');
            $table->id();
            $table->unsignedInteger('current_rank')->length(4)->comment('現在のランク');
            $table->integer('rank_change')->length(6)->commnet('前回ランクからの変化');
            $table->unsignedInteger('current_point')->comment('現在の所持ポイント');
            $table->date('updated_ymd')->comment('ランキングが更新された日');
            $table->foreignId('player_id')
                ->constrained('players')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->unique(['player_id','updated_ymd']);
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
        Schema::dropIfExists('tennis_atp_rankings');
    }
};
