<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->comment('ćć');
            $table->timestamps();
            $table->comment('éšć±');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};
