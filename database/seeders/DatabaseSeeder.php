<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Size;
use App\Models\Type;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory()->create();

        // ProductCategory::factory(5)->create();
        // Product::factory()->create();
        // Size::factory()->create();

        // ProductCategory::factory()->create([
        //     'name' => 'Chicken Eggs',
        //     'status' => 1,
        // ]);
        // ProductCategory::factory()->create([
        //     'name' => 'Duck Eggs',
        //     'status' => 1,
        // ]);
        // ProductCategory::factory()->create([
        //     'name' => 'Ostrich Eggs',
        //     'status' => 1,
        // ]);
        // Size::factory()->create([
        //     'product_category_id' => 1,
        //     'sm_price' => 8.5,
        //     'md_price' => 10.0,
        //     'lg_price' => 12.75,
        //     'xl_price' => 15.50,
        // ]);
        // Size::factory()->create([
        //     'product_category_id' => 2,
        //     'sm_price' => 8.5,
        //     'md_price' => 10.0,
        //     'lg_price' => 12.75,
        //     'xl_price' => 15.50,
        // ]);
        // Size::factory()->create([
        //     'product_category_id' => 3,
        //     'sm_price' => 8.5,
        //     'md_price' => 10.0,
        //     'lg_price' => 12.75,
        //     'xl_price' => 15.50,
        // ]);
        // Product::factory()->create([
        //     'product_category_id' => 1,
        //     'sm_stock' => 20,
        //     'md_stock' => 25,
        //     'lg_stock' => 30,
        //     'xl_stock' => 35,
        // ]);
        // Product::factory()->create([
        //     'product_category_id' => 1,
        //     'sm_stock' => 20,
        //     'md_stock' => 25,
        //     'lg_stock' => 30,
        //     'xl_stock' => 35,
        // ]);
        // Product::factory()->create([
        //     'product_category_id' => 2,
        //     'sm_stock' => 20,
        //     'md_stock' => 25,
        //     'lg_stock' => 30,
        //     'xl_stock' => 35,
        // ]);
        // Product::factory()->create([
        //     'product_category_id' => 2,
        //     'sm_stock' => 20,
        //     'md_stock' => 25,
        //     'lg_stock' => 30,
        //     'xl_stock' => 35,
        // ]);
        // Product::factory()->create([
        //     'product_category_id' => 3,
        //     'sm_stock' => 20,
        //     'md_stock' => 25,
        //     'lg_stock' => 30,
        //     'xl_stock' => 35,
        // ]);
        // Product::factory()->create([
        //     'product_category_id' => 3,
        //     'sm_stock' => 20,
        //     'md_stock' => 25,
        //     'lg_stock' => 30,
        //     'xl_stock' => 35,
        // ]);

        // User::factory()->create([
        //     'address' => 'Cagayan de Oro City'
        // ]);

        $eggid = Type::factory()->create([
            'name' => 'Eggs',
        ]);

        $meatid = Type::factory()->create([
            'name' => 'Meat',
        ]);
        $manureid = Type::factory()->create([
            'name' => 'Manure',
        ]);

        Unit::factory()->create([
            'unit' => 'small',
            'type_id' => $eggid,
        ]);
        Unit::factory()->create([
            'unit' => 'medium',
            'type_id' => $eggid,
        ]);
        Unit::factory()->create([
            'unit' => 'large',
            'type_id' => $eggid,
        ]);
        Unit::factory()->create([
            'unit' => 'x-large',
            'type_id' => $eggid,
        ]);
        Unit::factory()->create([
            'unit' => 'per kilo',
            'type_id' => $meatid,
        ]);
        Unit::factory()->create([
            'unit' => 'per head',
            'type_id' => $meatid,
        ]);
        Unit::factory()->create([
            'unit' => 'per sack',
            'type_id' => $manureid,
        ]);
    }
}
