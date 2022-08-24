<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('round_upcards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('round_id')->comment('対戦ラウンドID');
            $table->string('suit', 10)->comment('カードのシンボル');
            $table->unsignedTinyInteger('number')->comment('カードの数字');
            $table->timestamps();
            $table->comment('場札');
        });
    }

    public function down()
    {
        Schema::dropIfExists('round_upcards');
    }
};
