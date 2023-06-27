<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('user_cryptos', function (Blueprint $table) {
            $table->id();
            $table->integer('cmc_id');
            $table->foreignId('account_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->float('amount');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cryptos');
    }
};
