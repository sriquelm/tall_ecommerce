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
            'Tienda' => [
                "Libros",
                "Recorridos",
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
