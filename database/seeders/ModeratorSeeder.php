<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ModeratorSeeder extends Seeder
{
    public function run(): void
    {
        $moderatorRole = Role::where('name', 'moderator')->first();

        $moderator1 = User::firstOrCreate(
            ['email' => 'moderator@example.com'],
            [
                'name' => 'Moderator',
                'password' => Hash::make('password'),
            ]
        );
        if (!$moderator1->roles()->where('role_id', $moderatorRole->id)->exists()) {
            $moderator1->roles()->attach($moderatorRole);
        }

        $moderator2 = User::firstOrCreate(
            ['email' => 'kolamiloserdov326@mail.ru'],
            [
                'name' => 'Nikolay Miloserdov',
                'password' => Hash::make('password1'),
            ]
        );
        if (!$moderator2->roles()->where('role_id', $moderatorRole->id)->exists()) {
            $moderator2->roles()->attach($moderatorRole);
        }
    }
}
