<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cipta akaun admin baru secara manual';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('--- Cipta Akaun Admin Baru ---');

        $firstName = $this->ask('Nama Pertama');
        $lastName = $this->ask('Nama Akhir');
        $username = $this->ask('Username');
        $email = $this->ask('Alamat Email');
        $password = $this->secret('Kata Laluan');
        $confirmPassword = $this->secret('Sahkan Kata Laluan');

        if ($password !== $confirmPassword) {
            $this->error('Kata laluan tidak sepadan!');
            return 1;
        }

        if (User::where('email', $email)->exists() || User::where('username', $username)->exists()) {
            $this->error('Email atau Username sudah wujud dalam sistem!');
            return 1;
        }

        try {
            User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'username' => $username,
                'email' => $email,
                'password' => \Illuminate\Support\Facades\Hash::make($password),
                'role_id' => 1, // Admin
                'is_active' => 1,
                'picture' => User::DEFAULT_PICTURE,
                'email_verified_at' => now(),
            ]);

            $this->info('Akaun Admin berjaya dicipta!');
            return 0;
        } catch (\Exception $e) {
            $this->error('Ralat semasa mencipta akaun: ' . $e->getMessage());
            return 1;
        }
    }
}
