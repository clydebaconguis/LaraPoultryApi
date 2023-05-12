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
        User::factory()->create([
            'name' => 'Admin Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('secret'),
        ]);
    }
}
