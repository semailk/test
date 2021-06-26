<?php

namespace Database\Seeders;

use App\Models\Avatar;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory([
            'name' => 'qweqwe',
            'email' => 'qweqwe@mail.ru',
            'password' => Hash::make('qweqweqwe')
        ])->has(Post::factory()->count(3))->has(Avatar::factory()->count(1))->create();
        $role = Role::create(['name' => 'admin']);
        $user->assignRole($role);

        User::factory()->has(Post::factory()->count(3), 'posts')->has(Avatar::factory()->count(1))->count(10)->create();

    }
}
