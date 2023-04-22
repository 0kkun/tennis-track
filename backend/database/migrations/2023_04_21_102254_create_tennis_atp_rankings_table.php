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
            $table->unsignedInteger('pre_rank')->nullable()->comment('前回ランク');
            $table->integer('rank_change')->length(6)->commnet('前回ランクからの変化');
            $table->unsignedInteger('most_highest_rank')->length(4)->nullable()->comment('これまでの一番高いランキング');
            $table->unsignedInteger('current_point')->comment('現在の所持ポイント');
            $table->integer('point_change')->length(6)->comment('前回ポイントからの変化');
            $table->string('current_tour_result_en', 200)->commnet('現在参加している大会の結果');
            $table->string('current_tour_result_jp', 200)->commnet('現在参加している大会の結果');
            $table->string('pre_tour_result_en', 200)->comment('前回大会の結果');
            $table->string('pre_tour_result_jp', 200)->comment('前回大会の結果');
            $table->unsignedInteger('next_point')->length(6)->comment('次に勝つと入手できるポイント');
            $table->unsignedInteger('max_point')->length(6)->commnet('現在参加している大会で全部勝てばどれだけポイントが入手できるか');
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
