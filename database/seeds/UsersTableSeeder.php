<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Kopp\User::insert([
            [
                'name' => 'Копп Сергей Владимирович',
                'phone' => '+7 (913) 796-96-36',
                'address' => 'г. Новосибирск, ул. Берёзовая 1, 104',
                'email' => 'sergeykopp@yandex.ru',
                'password' => '$2y$10$lA970x6CE9PD/oQ6M6zULOFTk5HJKQnUXIJ7NAYFK5/8luT7HXXfW',
                'remember_token' => 'u6ce6rQNTSXh2Npf1kYmxiqWmwe8iUVRggSmmKEqodHCxO3wi9TmtirjVyvf',
                'created_at' => '2017-01-02 13:49:39',
                'updated_at' => '2017-01-02 14:35:28',
            ],
        ]);
    }
}
