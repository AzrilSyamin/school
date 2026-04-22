<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::updateOrCreate(['id' => 1], ['name' => 'Admin']);
        Role::updateOrCreate(['id' => 2], ['name' => 'Moderator']);
        Role::updateOrCreate(['id' => 3], ['name' => 'Lecturer']);
        Role::updateOrCreate(['id' => 4], ['name' => 'Student']);
        Role::updateOrCreate(['id' => 5], ['name' => 'Classrep']);
    }
}
