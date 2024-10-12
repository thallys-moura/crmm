<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('billing_observation')->nullable()->after('billing_status_id'); // Adiciona a coluna após o campo status
        });
    }
    
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('billing_observation');
        });
    }
};
