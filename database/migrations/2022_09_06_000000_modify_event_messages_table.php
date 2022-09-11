<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::table('event_messages', function (Blueprint $table) {
            $table->dropColumn(['journal_id', 'room_id']);
        });
    }

    public function down()
    {
        Schema::table('event_messages', function (Blueprint $table) {
            $table->unsignedBigInteger('journal_id')
                ->comment('イベントジャーナルID');
            $table->unsignedBigInteger('room_id')
                ->comment('部屋ID');
        });
    }
};
