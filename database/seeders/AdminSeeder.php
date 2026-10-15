<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Create the initial admin account.
     *
     * Password source priority:
     *   1. ADMIN_PASSWORD environment variable (if set)
     *   2. Randomly generated 20-character password (printed once)
     *
     * Never hard-code a production password in source code.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@guhangakazi.rw');

        if (Admin::where('email', $email)->exists()) {
            $this->command->info("Admin already exists: {$email}");
            return;
        }

        $password = env('ADMIN_PASSWORD');
        $generated = false;

        if (empty($password)) {
            $password = Str::random(16) . rand(10, 99) . '!';
            $generated = true;
        }

        Admin::create([
            'name'       => env('ADMIN_NAME', 'GuhangaAkazi Admin'),
            'email'      => $email,
            'password'   => Hash::make($password),
            'is_active'  => true,
        ]);

        $this->command->info('=========================================');
        $this->command->info('INITIAL ADMIN CREATED');
        $this->command->info('Email    : ' . $email);

        if ($generated) {
            $this->command->warn('Password : ' . $password);
            $this->command->warn('SAVE THIS PASSWORD NOW - it will not be shown again.');
        } else {
            $this->command->info('Password : (loaded from ADMIN_PASSWORD env)');
        }

        $this->command->info('=========================================');
    }
}
