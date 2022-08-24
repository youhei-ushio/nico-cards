<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id')->comment('部屋ID');
            $table->unsignedInteger('turn')->comment('ターン');
            $table->boolean('reversed')->default(false)->comment('革命による反転中か');
            $table->boolean('finished')->default(false)->comment('終了したか');
            $table->timestamps();
            $table->unique('room_id');
            $table->comment('対戦ラウンド');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rounds');
    }
};
