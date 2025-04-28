<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departamentos')->insert([
            ['coddpto' => '01', 'nombre_departamento' => 'AHUACHAPAN'],
            ['coddpto' => '02', 'nombre_departamento' => 'SANTA ANA'],
            ['coddpto' => '03', 'nombre_departamento' => 'SONSONATE'],
            ['coddpto' => '04', 'nombre_departamento' => 'CHALATENANGO'],
            ['coddpto' => '05', 'nombre_departamento' => 'LA LIBERTAD'],
            ['coddpto' => '06', 'nombre_departamento' => 'SAN SALVADOR'],
            ['coddpto' => '07', 'nombre_departamento' => 'CUSCATLAN'],
            ['coddpto' => '08', 'nombre_departamento' => 'LA PAZ'],
            ['coddpto' => '09', 'nombre_departamento' => 'CABAÑAS'],
            ['coddpto' => '10', 'nombre_departamento' => 'SAN VICENTE'],
            ['coddpto' => '11', 'nombre_departamento' => 'USULUTAN'],
            ['coddpto' => '12', 'nombre_departamento' => 'SAN MIGUEL'],
            ['coddpto' => '13', 'nombre_departamento' => 'MORAZAN'],
            ['coddpto' => '14', 'nombre_departamento' => 'LA UNION'],
        ]);
    }
}
