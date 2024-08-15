<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Burger;
use App\Models\Command;
use Illuminate\Database\Eloquent\Factories\Factory;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        //\Illuminate\Database\Eloquent\Factories\Factory::factoryForModel(Burger::class)->count(10)->create();
       // \Illuminate\Database\Eloquent\Factories\Factory::factoryForModel(Vehicule::class)->count(10)->create();
       // \Illuminate\Database\Eloquent\Factories\Factory::factoryForModel(Command::class)->count(10)->create();
       
    }
}
