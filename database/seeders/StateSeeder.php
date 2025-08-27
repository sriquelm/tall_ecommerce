<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        $states = [
            [ 'name' => 'Arica y Parinacota', 'active' => true ], 
            [ 'name' => 'Tarapacá', 'active' => true ], 
            [ 'name' => 'Antofagasta', 'active' => true ], 
            [ 'name' => 'Atacama', 'active' => true ], 
            [ 'name' => 'Coquimbo', 'active' => true ], 
            [ 'name' => 'Valparaíso', 'active' => true ], 
            [ 'name' => 'Región del Libertador Gral. Bernardo O’Higgins', 'active' => true ], 
            [ 'name' => 'Región del Maule', 'active' => true ], 
            [ 'name' => 'Región de Ñuble', 'active' => true ], 
            [ 'name' => 'Región del Biobío', 'active' => true ], 
            [ 'name' => 'Región de la Araucanía', 'active' => true ], 
            [ 'name' => 'Región de Los Ríos', 'active' => true ], 
            [ 'name' => 'Región de Los Lagos', 'active' => true ], 
            [ 'name' => 'Región Aisén del Gral. Carlos Ibáñez del Campo', 'active' => true ], 
            [ 'name' => 'Región de Magallanes y de la Antártica Chilena', 'active' => true ], 
            [ 'name' => 'Región Metropolitana de Santiago', 'active' => true ], 
        ];

        foreach ($states as $state) {
            State::firstOrCreate(['name' => $state['name']], $state);
        }
    }
}
