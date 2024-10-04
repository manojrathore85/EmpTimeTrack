<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        Department::insert([
            [
                'name' => 'Hr',
                'created_at' => $now,
            ],
            [
                'name' => 'IT',
                'created_at' => $now,
            ],
            [
                'name' => 'Accounts',
                'created_at' => $now,
            ]
        ]);
    }
}
