<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlackListTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('black_list', function (Blueprint $table) {
            $table->id(); // id como auto-incremento
            $table->date('sale_date')->nullable(); // Data da venda
            $table->unsignedBigInteger('lead_id'); // Referência para a tabela leads
            $table->unsignedBigInteger('person_id'); // Pessoa
            $table->unsignedBigInteger('user_id'); // Usuário
            $table->text('observations')->nullable(); // Observações
            $table->text('client_observations')->nullable(); // Observações do cliente
            $table->integer('billed')->default(0); // Faturado
            $table->unsignedBigInteger('seller_id'); // Vendedor
            $table->timestamps();

            // Foreign keys
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('black_list');
    }
}