<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('hands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id')->comment('部屋ID');
            $table->unsignedBigInteger('user_id')->comment('メンバーID');
            $table->string('suit', 10)->comment('カードのシンボル');
            $table->unsignedTinyInteger('number')->comment('カードの数字');
            $table->unique([
                'room_id',
                'user_id',
                'suit',
                'number',
            ]);
            $table->timestamps();
            $table->comment('手札');
        });
    }

    public function down()
    {
        Schema::dropIfExists('hands');
    }
};
