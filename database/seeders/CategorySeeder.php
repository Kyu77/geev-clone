<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::query()->delete();
        Category::create(["name" => "Électronique"]);
        Category::create(["name" => "Mode et accessoires"]);
        Category::create(["name" => "Maison et décoration"]);
        Category::create(["name" => "Loisirs et divertissements"]);
        Category::create(["name" => "Véhicules et accesoires"]);
        Category::create(["name" => "Jardin et bricolage"]);
        Category::create(["name" => "Beauté et bien-être"]);
        Category::create(["name" => "Bébé et enfnat"]);
        Category::create(["name" => "Animaux"]);
        Category::create(["name" => "Collections et objets d'art"]);
        Category::create(["name" => "Évenement et services"]);
        Category::create(["name" => "Équipements professionels"]);
        Category::create(["name" => "Autres"]);
    }
}
