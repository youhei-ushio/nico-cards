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
            $table->unsignedBigInteger('room_id')->comment('部屋ID');
            $table->unsignedBigInteger('user_id')->comment('メンバーID');
            $table->unique([
                'room_id',
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
