<?php

namespace Database\Seeders;

use App\Models\Quality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QualitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Quality::create(["name" => "Neuf"]);
        Quality::create(["name" => "Très bon état"]);
        Quality::create(["name" => "Bon état"]);
        Quality::create(["name" => "À réparer"]);
        Quality::create(["name" => "Reconditionner"]);
        Quality::create(["name" => "Usagé"]);

    }
}
