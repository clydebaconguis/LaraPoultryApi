<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Sale;
use App\Models\Size;
use App\Models\Type;
use App\Models\Unit;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $eggid = Type::factory()->create([
            'name' => 'Eggs',
        ]);

        $meatid = Type::factory()->create([
            'name' => 'Meat',
        ]);
        $manureid = Type::factory()->create([
            'name' => 'Manure',
        ]);
        $wholeid = Type::factory()->create([
            'name' => 'Whole Chicken',
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
        Unit::factory()->create([
            'unit' => 'Whole chicken',
            'type_id' => $wholeid,
        ]);
        User::factory()->create([
            'name' => 'Admin Admin',
            'role' => 'admin',
            'email' => 'admin@admin.com',
            'phone' => '09554587790',
            'password' => Hash::make('secret'),
        ]);
        User::factory()->create([
            'name' => 'Courier',
            'role' => 'courier',
            'email' => 'courier@courier.com',
            'phone' => '09554587790',
            'password' => Hash::make('Courier#123'),
        ]);

        Sale::factory()->create([
            'rider_id' => 1,
            'profit' => 100.00,
        ]);
        Sale::factory()->create([
            'rider_id' => 2,
            'profit' => 200.25,
        ]);
        Sale::factory()->create([
            'rider_id' => 3,
            'profit' => 320.75,
        ]);
    }
}
