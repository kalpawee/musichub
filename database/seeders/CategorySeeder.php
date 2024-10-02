<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Concerts',
            'Music Festivals',
            'Club Nights',
            'DJ Sets',
            'Open Mic Nights',
            'Battle of the Bands',
            'Acoustic Sessions',
            'Opera',
            'Album Release Parties',
            'Charity Concerts',
            'Silent Discos',
            'Music Awards Shows',
            'Music Conferences',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}

