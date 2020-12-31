<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'store' => rand(1,3),
            'name' => $this->faker->name,
            'caption' => $this->faker->sentence,
            'brand' => $this->faker->company,
            'storage_initial' => 5,

            // 'storage_current' => $this->faker->integer,
            
            'description' => $this->faker->paragraphs(rand(2,10), true),
            'details' => $this->faker->paragraphs(rand(2,10), true),
            'price' => rand(23,1238),
            'discount' => rand(0,15),

            // 'photo1' => $this->faker->(),
            // 'photo2' => $this->faker->(),
            // 'photo3' => $this->faker->(),
            // 'photo4' => $this->faker->(),
            // 'photo5' => $this->faker->(),
            // 'photo6' => $this->faker->(),
            
            'video' => 'https://www.youtube.com/watch?v=Q_L-0Ryhmic',
        ];
    }
}
