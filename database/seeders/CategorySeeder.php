<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            'Special Collection' => [
                "Rustic Wall Art",
                "Vintage Wall Decor",
                "Geometric Wall Art",
                "Botanical Wall Decor",
                "Boho Wall Art",
                "Coastal Wall Decor",
                "Typography Wall Art",
                "Minimalist Wall Art",
                "Contemporary Wall Decor",
                "Sculptural Wall Art",
                "Eclectic Wall Decor",
                "Mid-century Modern Wall Art",
                "Inspirational Wall Art",
            ]

        ];

        foreach ($data as $key => $value) {
            $category = Category::create(['name' => $key]);
            foreach ($value as $cat) {
                Category::create(['name' => $cat, 'parent_id' => $category->id]);
            }
        }
    }
}
