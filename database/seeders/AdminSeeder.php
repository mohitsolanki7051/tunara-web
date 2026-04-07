<?php
namespace Database\Seeders;
use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        AdminUser::updateOrCreate(
            ['email' => env('ADMIN_EMAIL')],
            [
                'name'     => env('ADMIN_NAME', 'Mohit'),
                'password' => Hash::make(env('ADMIN_PASSWORD')),
            ]
        );
    }
}
