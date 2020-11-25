<?php

use Illuminate\Database\Seeder;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Kopp\OrderStatus::insert([
            ['name' => 'Оформлен клиентом'],
            ['name' => 'В ожидании от поставщика'],
            ['name' => 'Доставлен от поставщика'],
            ['name' => 'Доставлен клиенту'],
        ]);
    }
}
