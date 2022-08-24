<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('round_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('round_id')->comment('対戦ラウンドID');
            $table->unsignedBigInteger('user_id')->comment('メンバーID');
            $table->boolean('on_turn')->default(false)->comment('ターン中かどうか');
            $table->unsignedTinyInteger('rank')->default(0)->comment('順位');
            $table->unique([
                'round_id',
                'user_id',
            ]);
            $table->timestamps();
            $table->comment('対戦メンバー');
        });
    }

    public function down()
    {
        Schema::dropIfExists('round_users');
    }
};
