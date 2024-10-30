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
        Schema::create('expense_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome do tipo de despesa
            $table->timestamps();
        });

        // Inserindo os valores iniciais
        DB::table('expense_types')->insert([
            ['name' => 'Despesas (USD)'],
            ['name' => 'Despesas (BRL)'],
            ['name' => 'Receita (BRL)'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_types');
    }
};
