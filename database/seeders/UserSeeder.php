<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Mina Hawarei',
            'email' => 'mina.hawarei@gmail.com',
            'password' => Hash::make('123456789'), // استخدم Hash لتشفير كلمة المرور
            'role' => 'admin', // إذا كان لديك حقل "role" في جدول المستخدمين
        ]

    );
    }
}
