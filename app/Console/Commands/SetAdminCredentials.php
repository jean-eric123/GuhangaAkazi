<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SetAdminCredentials extends Command
{
    protected $signature = 'app:set-admin {current_email? : Current admin email (blank = use the first admin)}';
    protected $description = "Securely update an admin's email, name, and password";

    public function handle(): int
    {
        $currentEmail = $this->argument('current_email');

        $admin = $currentEmail
            ? Admin::where('email', $currentEmail)->first()
            : Admin::first();

        if (! $admin) {
            $this->error('No admin found. Run AdminSeeder first.');
            return self::FAILURE;
        }

        $this->info('Updating admin: ' . $admin->email);

        $newEmail = $this->ask('New email', $admin->email);
        $newName  = $this->ask('New name', $admin->name);

        if (! filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid email address.');
            return self::FAILURE;
        }

        if ($newEmail !== $admin->email && Admin::where('email', $newEmail)->exists()) {
            $this->error('That email is already used by another admin.');
            return self::FAILURE;
        }

        $password = $this->secret('New password (min 10 chars - nothing shows while typing)');
        if (! is_string($password) || strlen($password) < 10) {
            $this->error('Password must be at least 10 characters.');
            return self::FAILURE;
        }

        $confirm = $this->secret('Confirm new password');
        if ($password !== $confirm) {
            $this->error('Passwords do not match.');
            return self::FAILURE;
        }

        $admin->update([
            'email'    => $newEmail,
            'name'     => $newName,
            'password' => Hash::make($password),
        ]);

        $this->info('=========================================');
        $this->info('ADMIN UPDATED SUCCESSFULLY');
        $this->info('Name : ' . $newName);
        $this->info('Email: ' . $newEmail);
        $this->info('=========================================');

        return self::SUCCESS;
    }
}
