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
            $table->string('id')->primary();
            $table->string('name_en', 100)->nullable()->comment('選手名(英)');
            $table->string('name_ja', 100)->nullable()->comment('選手名(和)');
            $table->string('country', 100)->nullable()->comment('出身国');
            $table->string('country_code', 100)->nullable()->comment('出身国コード');
            $table->string('abbreviation', 100)->nullable()->comment('略称');
            $table->unsignedTinyInteger('gender')->nullable()->comment('性別[0:男/1:女]');
            $table->date('birthday')->nullable()->comment('生年月日');
            $table->year('pro_year')->nullable()->comment('プロ転向年');
            $table->unsignedTinyInteger('handedness')->nullable()->comment('利き腕[0:右/1:左]');
            $table->unsignedInteger('weight')->nullable()->comment('体重[Kg]');
            $table->unsignedFloat('height')->nullable()->comment('身長[cm]');
            $table->unsignedInteger('highest_singles_ranking')->nullable()->comment('生涯最高シングルスランク');
            $table->unsignedInteger('highest_doubles_ranking')->nullable()->comment('生涯最高シングルスランク');
            $table->foreignId('sport_category_id')
                ->constrained('sport_categories')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
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
