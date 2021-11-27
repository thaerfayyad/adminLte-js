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

            'name'         => $this-> faker-> word,
            'description' => $this-> faker-> sentence(5),
            'status'       => $this-> faker-> boolean(40),
            'img'       => '0',
            'subcategory_id' =>$this-> faker->randomDigit,


        ];
    }
}
