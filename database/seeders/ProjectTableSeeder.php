<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        Project::insert([
            [
                'department_id' => '1',
                'name'=> 'HrModule',
                'created_at' => $now,
            ],            
            [
                'department_id' => '2',
                'name'=> 'CRMApplication',
                'created_at' => $now,
            ],
            [
                'department_id' => '3',
                'name'=> 'E-commerceWebSite',
                'created_at' => $now,
            ],
        ]);
    }
}
