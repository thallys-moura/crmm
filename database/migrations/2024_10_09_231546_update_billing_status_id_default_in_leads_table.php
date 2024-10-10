<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Obtém o ID do status "Pendente"
        $pendingStatusId = DB::table('billing_status')->where('status', 'Pendente')->first()->id;
    
        Schema::table('leads', function (Blueprint $table) use ($pendingStatusId) {
            $table->unsignedBigInteger('billing_status_id')->default($pendingStatusId)->change(); // Define valor padrão
        });
    }
    
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->unsignedBigInteger('billing_status_id')->nullable()->change(); // Remove valor padrão se necessário
        });
    }
};
