<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Kopp\Category::insert([
            [
                'name' => 'Масштабные модели',
                'category_id' => 0,
            ],
            [
                'name' => 'Химия',
                'category_id' => 0,
            ],
            [
                'name' => 'Инструменты',
                'category_id' => 0,
            ],
            [
                'name' => 'Техника 1/35',
                'category_id' => 1,
            ],
            [
                'name' => 'Техника 1/72',
                'category_id' => 1,
            ],
            [
                'name' => 'Самолёты 1/48',
                'category_id' => 1,
            ],
            [
                'name' => 'Самолёты 1/72',
                'category_id' => 1,
            ],
            [
                'name' => 'Вертолёты 1/72',
                'category_id' => 1,
            ],
            [
                'name' => 'Дополнительно',
                'category_id' => 1,
            ],
            [
                'name' => 'Клей',
                'category_id' => 2,
            ],
            [
                'name' => 'Краска акриловая',
                'category_id' => 2,
            ],
            [
                'name' => 'Краска мастер-акрил',
                'category_id' => 2,
            ],
            [
                'name' => 'Дрели и свёрла',
                'category_id' => 3,
            ],
            [
                'name' => 'Кисти',
                'category_id' => 3,
            ],
            [
                'name' => 'Наждачная бумага',
                'category_id' => 3,
            ],
            [
                'name' => 'Режущий инструмент',
                'category_id' => 3,
            ],
            [
                'name' => 'Прочий инструмент',
                'category_id' => 3,
            ],
        ]);
    }
}
