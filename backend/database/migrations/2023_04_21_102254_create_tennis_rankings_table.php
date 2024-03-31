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
        Schema::create('tennis_rankings', function (Blueprint $table) {
            $table->comment('ランキング管理テーブル');
            $table->id();
            $table->string('tennis_player_id')->comment('選手ID');
            $table->foreign('tennis_player_id')
                ->references('id')
                ->on('tennis_players')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->unsignedInteger('rank')->length(4)->comment('現在のランク');
            $table->integer('movement')->length(6)->commnet('前回ランクからの変化');
            $table->unsignedInteger('point')->comment('現在の所持ポイント');
            $table->string('type')->comment('atp_singles,atp_doubles,wta_singles,wta_doubles');
            $table->unsignedInteger('played_count')->commnet('トーナメント出場回数');
            $table->date('ranking_date')->comment('ランキングが更新された日');
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
        Schema::dropIfExists('tennis_rankings');
    }
};
