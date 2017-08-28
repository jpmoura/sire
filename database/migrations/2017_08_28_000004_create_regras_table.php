<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegrasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'regras';

    /**
     * Run the migrations.
     * @table regras
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('quantidade_horarios_matutino');
            $table->integer('quantidade_horarios_vespertino');
            $table->integer('quantidade_horarios_noturno');
            $table->integer('quantidade_dias_reservaveis');
            $table->time('horario_inicio_matutino')->nullable()->default(null);
            $table->time('horario_inicio_vespertino')->nullable()->default(null);
            $table->time('horario_inicio_noturno')->nullable()->default(null);
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
