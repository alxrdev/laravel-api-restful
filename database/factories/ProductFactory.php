<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
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
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph(1),
            'quantity' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement([Product::PRODUCT_AVAILABLE, Product::PRODUCT_UNAVAILABLE]),
            'image' => $this->faker->randomElement(['1.jpg', '2.jpg', '3.jpg']),
            'seller_id' => User::all()->random()->id
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Product &$product) {
            $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');
            $product->categories()->attach($categories);
        });
    }
}
