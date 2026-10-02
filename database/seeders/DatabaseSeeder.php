<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (app()->environment('production')) {
            $email = env('ADMIN_EMAIL');
            $password = env('ADMIN_PASSWORD');

            if ($email && $password) {
                User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => env('ADMIN_NAME', 'Administrateur'),
                        'password' => Hash::make($password),
                    ]
                );
            }

            return;
        }

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
