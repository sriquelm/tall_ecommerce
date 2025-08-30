<?php

namespace Database\Seeders;

use App\Models\Variant;
use App\Models\Product;
use Illuminate\Support\Arr;
use Facades\App\Helpers\SKU;
use App\Models\VariantOption;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VariantSeeder extends Seeder
{
    protected $sizes = ['small'];
    protected $colors = ['blue'];

    protected function getCombinations(): array
    {
        $combinations = [];
        foreach ($this->sizes as $size) {
            foreach ($this->colors as $color) {
                $combinations[] = [$color, $size];
            }
        }
        return $combinations;
    }

    protected function getOne($name, $key)
    {
        $data =  $this->{$name};
        return $data[$key];
    }



    public function run(): void
    {
        Product::all()->each(function ($product) {
            // Get color, size or both dynamically
            $options = Arr::random(['color', 'size'], 0);

            // create product variation for each option
            foreach ($options as $value) {
                VariantOption::create(['product_id' => $product->id, 'name' => $value]);
            }

            Variant::factory(1)
                ->sequence(fn () => ['sku' => SKU::make($product->title)])
                ->create(['product_id' => $product->id]);

            // Dynamically attach different values of Size, Color or Both
            $product->variants->each(function ($variant, $key) use ($product) {
                $numOptions = $product->variantOptions()->count();

            
                $product->variantOptions->each(
                    fn ($option, $key) =>
                    $option->options()
                        ->attach($variant->id, ['value' => Arr::random($this->{$option->name . 's'})])
                );
                
            });
        });
    }
}
