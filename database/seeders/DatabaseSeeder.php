<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Isabel Graterol',
            'user' => 'Master',
            'password' => Hash::make("paromenia")
        ]);

        \App\Models\Patria::factory()->create(['opciones' => 'Actualización']);
        \App\Models\Patria::factory()->create(['opciones' => 'Bonos']);
        \App\Models\Patria::factory()->create(['opciones' => 'Cambio de contraseña']);
        \App\Models\Patria::factory()->create(['opciones' => 'Recuperar acceso']);
        \App\Models\Patria::factory()->create(['opciones' => 'Primera vez']);
        \App\Models\Patria::factory()->create(['opciones' => 'Renuncia beneficio']);
        \App\Models\Patria::factory()->create(['opciones' => 'VenApp']);
        \App\Models\Patria::factory()->create(['opciones' => 'Transferencia Petro']);
        \App\Models\Patria::factory()->create(['opciones' => 'Alistamiento']);
        \App\Models\Patria::factory()->create(['opciones' => 'Asesoramiento']);
    }
}
