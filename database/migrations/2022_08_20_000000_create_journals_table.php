<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->string('type', 10)->comment('イベント種別(enter,leave,start,deal,play,pass,end)');
            $table->unsignedBigInteger('room_id')->comment('部屋ID');
            $table->unsignedBigInteger('user_id')->nullable()->comment('メンバーID');
            $table->json('payload')->nullable()->comment('イベント毎のデータ');
            $table->timestamps();
            $table->index('room_id');
            $table->comment('イベントジャーナル');
        });
    }

    public function down()
    {
        Schema::dropIfExists('journals');
    }
};
