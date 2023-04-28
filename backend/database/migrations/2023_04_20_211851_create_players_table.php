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
            $table->string('name_en', 100)->comment('選手名(英)');
            $table->string('name_jp', 100)->nullable()->comment('選手名(和)');
            $table->string('country', 100)->nullable()->comment('出身');
            $table->string('link', 2000)->nullable()->comment('選手情報詳細サイトのリンク');
            $table->date('birthday')->nullable()->comment('生年月日');
            $table->unsignedInteger('weight')->nullable()->comment('体重[Kg]');
            $table->unsignedFloat('height')->nullable()->comment('身長[cm]');
            $table->year('turn_to_pro_year')->nullable()->comment('プロ転向年');
            $table->unsignedTinyInteger('gender')->nullable()->comment('性別[0:男/1:女]');
            $table->unsignedTinyInteger('dominant_arm')->nullable()->comment('利き腕[0:右/1:左]');
            $table->unsignedTinyInteger('backhand_style')->nullable()->comment('バックハンド[0:片手/1:両手]');
            $table->foreignId('sport_category_id')
                ->constrained('sport_categories')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->unique(['name_en', 'sport_category_id']);
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
