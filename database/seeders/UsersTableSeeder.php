<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles if they don't already exist
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);

        // Create users and assign roles

        // Employee 1
        $employee1 = User::create([
            'name' => 'Employee One',
            'email' => 'employee1@example.com',
            'password' => Hash::make('password'), // Default password
        ]);
        $employee1->assignRole($employeeRole);

        // Employee 2
        $employee2 = User::create([
            'name' => 'Employee Two',
            'email' => 'employee2@example.com',
            'password' => Hash::make('password'),
        ]);
        $employee2->assignRole($employeeRole);

        // Manager 1
        $manager1 = User::create([
            'name' => 'Manager One',
            'email' => 'manager1@example.com',
            'password' => Hash::make('password'),
        ]);
        $manager1->assignRole($managerRole);

        // Manager 2
        $manager2 = User::create([
            'name' => 'Manager Two',
            'email' => 'manager2@example.com',
            'password' => Hash::make('password'),
        ]);
        $manager2->assignRole($managerRole);
    }
}
