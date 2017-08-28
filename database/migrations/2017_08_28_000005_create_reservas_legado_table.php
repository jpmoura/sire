<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservasLegadoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'reservas_legado';

    /**
     * Run the migrations.
     * @table reservas_legado
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->char('usuario_id', 11);
            $table->integer('recurso_id');
            $table->date('data')->nullable()->default(null);
            $table->integer('horario')->nullable()->default(null);
            $table->char('turno', 1)->nullable()->default(null);

            $table->index(["recurso_id"], 'equId');

            $table->index(["usuario_id"], 'usuId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
