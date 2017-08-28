<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'reservas';

    /**
     * Run the migrations.
     * @table reservas
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

            $table->index(["recurso_id"], 'recurso_id');

            $table->index(["usuario_id"], 'usuario_id');


            $table->foreign('recurso_id', 'recurso_id')
                ->references('id')->on('recursos')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('usuario_id', 'usuario_id')
                ->references('cpf')->on('usuarios')
                ->onDelete('restrict')
                ->onUpdate('cascade');
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
