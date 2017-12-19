<?php

use Illuminate\Database\Seeder;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            'nome' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'nivel' => 1,
            'status' => 1
        ]);
    }
}
