<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MakeFilamentUserWithUsername extends Command
{
    protected $signature = 'make:filament-user-username';

    protected $description = 'Create a new Filament user using username instead of name';

    public function handle()
    {
        $username = $this->ask('Username');
        $email = $this->ask('Email address');
        $password = $this->secret('Password');

        $userClass = config('filament.auth.providers.users.model', \App\Models\User::class);

        $user = new $userClass();

        $user->username = $username;
        $user->email = $email;
        $user->password = Hash::make($password);

        $user->save();

        $this->info("Success! {$email} can now access Filament.");
    }
}
