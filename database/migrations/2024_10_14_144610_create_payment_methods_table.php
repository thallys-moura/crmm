<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id(); // chave primária
            $table->string('name'); // Nome do método de pagamento
            $table->timestamps();
        });

        // Adição da chave estrangeira payment_method_id na tabela quotes
        Schema::table('quotes', function (Blueprint $table) {
            $table->foreignId('payment_method_id')
                    ->nullable()  // Permitir que seja nulo
                    ->constrained('payment_methods') // Define a chave estrangeira para a tabela payment_methods
                    ->onDelete('set null'); // Se o método de pagamento for deletado, seta como null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remover a chave estrangeira e a coluna payment_method_id da tabela quotes
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropForeign(['payment_method_id']);
            $table->dropColumn('payment_method_id');
        });
        Schema::dropIfExists('payment_methods');
    }
};
