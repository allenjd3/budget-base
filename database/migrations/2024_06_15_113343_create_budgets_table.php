<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up (): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    public function down (): void
    {
        Schema::dropIfExists('budgets');
    }
};
