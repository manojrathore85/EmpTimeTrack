<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        User::factory()->count(100)->create();
    }
    
}
