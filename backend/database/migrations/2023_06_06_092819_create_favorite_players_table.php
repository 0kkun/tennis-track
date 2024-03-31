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
        Schema::create('favorite_tennis_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('tennis_player_id')->comment('選手ID');
            $table->foreign('tennis_player_id')
                ->references('id')
                ->on('tennis_players')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            // 複合ユニーク制約を追加
            $table->unique(['tennis_player_id', 'user_id']);
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
        Schema::dropIfExists('favorite_players');
    }
};
