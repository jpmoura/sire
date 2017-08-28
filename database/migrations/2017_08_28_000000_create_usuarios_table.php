<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'usuarios';

    /**
     * Run the migrations.
     * @table usuarios
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->char('cpf', 11);
            $table->string('nome', 45);
            $table->string('email', 45);
            $table->integer('nivel');
            $table->tinyInteger('status')->default('1');
            $table->string('remember_token')->nullable()->default(null);
            $table->char('meuicea_token', 32)->nullable()->default(null);

            $table->unique(["id"], 'id_UNIQUE');

            $table->unique(["cpf"], 'cpf_UNIQUE');
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
