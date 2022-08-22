<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('snapshots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journal_id')->comment('イベントジャーナルID');
            $table->unsignedBigInteger('room_id')->comment('部屋ID');
            $table->timestamps();
            $table->comment('スナップショット');
        });
    }

    public function down()
    {
        Schema::dropIfExists('snapshots');
    }
};
