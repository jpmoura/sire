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
            $table->integer('quantidade_horarios_matutino')->default('4');
            $table->integer('quantidade_horarios_vespertino')->default('4');
            $table->integer('quantidade_horarios_noturno')->default('4');
            $table->integer('quantidade_dias_reservaveis')->default('5');
            $table->time('horario_inicio_matutino')->default('08:00:00');
            $table->time('horario_inicio_vespertino')->default('13:00:00');
            $table->time('horario_inicio_noturno')->default('18:00:00');
            $table->integer('quantidade_horarios_seguidos')->default('2');
            $table->integer('intervalo_entre_horarios_seguidos')->default('20');
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
