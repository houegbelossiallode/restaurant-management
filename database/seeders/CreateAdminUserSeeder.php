<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (! $this->command) {
            throw new \RuntimeException('Run this seeder from an interactive terminal.');
        }

        $name = trim((string) $this->command->ask('Administrator name'));
        $email = trim((string) $this->command->ask('Administrator email'));

        if ($name === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('A name and a valid email address are required.');
        }

        $password = $this->command->secret('Administrator password');
        $confirmation = $this->command->secret('Confirm password');

        if (! is_string($password) || strlen($password) < 8 || $password !== $confirmation) {
            throw new \InvalidArgumentException('Passwords must match and contain at least 8 characters.');
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
            ]
        );

        $this->command->info('Administrator account created or updated.');
    }
}