<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'product_category_id' => 1,
            'size' => 'small',
            'total' => 500.00,
            'tray' => 50,
        ];
    }
}
