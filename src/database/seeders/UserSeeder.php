<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Alice account
        User::factory()->create([
            'name' => 'Alice',
            'email' => 'alice@mail.com',
        ]);

        // Create bob account
        User::factory()->create([
           'name' => 'Bob',
           'email' => 'bob@mail.com',
       ]);
    }
}
