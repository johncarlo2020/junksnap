<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class statusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create(['name' => 'Available']);
        Status::create(['name' => 'In Route']);
        Status::create(['name' => 'Grab']);
        Status::create(['name' => 'Delivery']);
        Status::create(['name' => 'Success']);
        Status::create(['name' => 'Cancel']);

    }
}
