<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use App\Models\User;
use App\Support\SiteContent;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        SiteContent::ensureImages();

        if (! SiteSetting::query()->exists()) {
            SiteSetting::query()->create([
                'data' => SiteContent::defaults(),
            ]);
        }

        $email = env('ADMIN_EMAIL', 'admin@facilitacapital.com');
        $password = env('ADMIN_PASSWORD');

        if (is_string($email) && $email !== '' && is_string($password) && $password !== '') {
            User::query()->updateOrCreate(
                ['email' => $email],
                [
                    'name' => 'Administrador',
                    'password' => $password,
                    'email_verified_at' => now(),
                ],
            );
        }
    }
}
