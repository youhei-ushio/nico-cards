<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('event_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journal_id')->comment('イベントジャーナルID');
            $table->unsignedBigInteger('user_id')->comment('メンバーID');
            $table->unsignedBigInteger('room_id')->comment('部屋ID');
            $table->string('body', 200)->comment('本文');
            $table->string('level', 20)->comment('レベル(info,warning,error)');
            $table->timestamps();
            $table->index('user_id');
            $table->comment('イベントメッセージ');
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_messages');
    }
};
