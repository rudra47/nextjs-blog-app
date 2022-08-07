<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name=$this->faker->word;
        return [
            'name'=>$name,
            'slug'=>Str::slug($name),
            'price'=>rand(50,100),
            'image'=>'user.png',
            'regular_price'=>rand(50,100),
        ];
    }
}
