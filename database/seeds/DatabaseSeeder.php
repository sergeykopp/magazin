<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(RolesTableSeeder::class);
         $this->call(RoleUserTableSeeder::class);
         $this->call(ProductsTableSeeder::class);
         $this->call(CategoriesTableSeeder::class);
         $this->call(OrdersTableSeeder::class);
         $this->call(OrderProductTableSeeder::class);
         $this->call(OrderStatusesTableSeeder::class);
         $this->call(BrandsTableSeeder::class);
    }
}
