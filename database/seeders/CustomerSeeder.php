<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'Customer1',
        ]);
        Customer::create([
            'name' => 'Customer2',
        ]);
        Customer::create([
            'name' => 'Customer3',
        ]);
        Customer::create([
            'name' => 'Customer4',
        ]);
    }
}