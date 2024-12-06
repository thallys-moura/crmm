<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('account')->nullable();
            $table->string('branch')->nullable();
            $table->decimal('balance', 15, 2)->default(0.00); // Ajuste conforme necessário para casas decimais
            $table->unsignedInteger('user_id')->nullable(); // Relacionamento com usuário, se necessário
            $table->text('observation')->nullable();
            $table->timestamps();

            // Foreign key para user_id, se aplicável
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banks');
    }
}