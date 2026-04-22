<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Core data required for the system to function (Production & Local)
        $this->call([
            RoleSeeder::class,
            SettingSeeder::class,
        ]);

        // Dummy data only for local development
        if (\Illuminate\Support\Facades\App::environment('local')) {
            $this->call(\Database\Seeders\Dev\DevDatabaseSeeder::class);
        }
    }
}
