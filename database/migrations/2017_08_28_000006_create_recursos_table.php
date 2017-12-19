<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecursosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'recursos';

    /**
     * Run the migrations.
     * @table recursos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('tipo_recurso_id');
            $table->string('nome', 50);
            $table->string('descricao', 100);
            $table->integer('status');

            $table->index(["tipo_recurso_id"], 'fk_recursos_tipo_recurso_id_idx');


            $table->foreign('tipo_recurso_id', 'fk_recursos_tipo_recurso_id_idx')
                ->references('id')->on('tipo_recurso')
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
