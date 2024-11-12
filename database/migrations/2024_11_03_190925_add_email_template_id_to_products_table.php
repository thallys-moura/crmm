<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailTemplateIdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Verifica se a coluna não existe, e então a cria
            if (!Schema::hasColumn('products', 'email_template_id')) {
                $table->unsignedBigInteger('email_template_id')->nullable();
            }

            // Verifica se a chave estrangeira não existe e a adiciona
            $table->foreign('email_template_id')
                  ->references('id')
                  ->on('email_templates')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Remove a chave estrangeira se existir
            $table->dropForeign(['email_template_id']);
            // Mantém ou remove a coluna dependendo de sua necessidade
            $table->dropColumn('email_template_id');
        });
    }
}
