<?php

namespace Database\Seeders;

use App\Models\Subproject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SubprojectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        Subproject::insert([
            [
                'project_id' => '1',
                'name' => 'AttendanceManagement',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'project_id' => '1',
                'name' => 'TaskManagement',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'project_id' => '1',
                'name' => 'LeaveManagement',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'project_id' => '2',
                'name' => 'InquirySystem',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'project_id' => '2',
                'name' => 'FollowupSystem',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'project_id' => '2',
                'name' => 'OrderManagement',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'project_id' => '3',
                'name' => 'InventoryManagement',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'project_id' => '3',
                'name' => 'Dispatch',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
