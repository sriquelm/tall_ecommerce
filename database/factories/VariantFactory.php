<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variant>
 */
class VariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = rand(50, 500);
        return [
            // 'purchase_price' => $price,
            'sale_price' => $price + rand(20, 30)*1000,
            'offer_price' => $price + rand(8, 15)*1000,
            'shipping_weight' => rand(1, 10),
            'stock' => mt_rand(10, 100),
        ];
    }
}
