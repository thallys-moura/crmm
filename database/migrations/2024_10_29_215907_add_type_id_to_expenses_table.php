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
        Schema::table('expenses', function (Blueprint $table) {
            // Adicionando a coluna `type_id` como chave estrangeira para `expense_types`
            $table->unsignedBigInteger('type_id')->after('id')->nullable(); 

            // Definindo a chave estrangeira com a tabela `expense_types`
            $table->foreign('type_id')->references('id')->on('expense_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Removendo a chave estrangeira e a coluna `type_id`
            $table->dropForeign(['type_id']);
            $table->dropColumn('type_id');
        });
    }
};
