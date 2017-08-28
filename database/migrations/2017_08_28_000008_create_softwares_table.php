<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwaresTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'softwares';

    /**
     * Run the migrations.
     * @table softwares
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('fabricante_software_id');
            $table->string('nome');
            $table->string('versao');
            $table->tinyInteger('status');

            $table->index(["fabricante_software_id"], 'fabricante_software_id');


            $table->foreign('fabricante_software_id', 'fabricante_software_id')
                ->references('id')->on('fabricante_softwares')
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
