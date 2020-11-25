<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Kopp\Brand::insert([
            ['name' => 'A-Model'],
            ['name' => 'Academy'],
            ['name' => 'ACE'],
            ['name' => 'ACM'],
            ['name' => 'AFV-Club'],
            ['name' => 'Airfix'],
            ['name' => 'Amusing Hobby'],
            ['name' => 'ARK Models'],
            ['name' => 'ARTmodel'],
            ['name' => 'Bravo-6'],
            ['name' => 'Bronco'],
            ['name' => 'Dragon'],
            ['name' => 'Eduard'],
            ['name' => 'Fine Molds'],
            ['name' => 'Flagman'],
            ['name' => 'Great Wall Hobby'],
            ['name' => 'Hasegawa'],
            ['name' => 'Heller'],
            ['name' => 'Hobby Boss'],
            ['name' => 'ICM'],
            ['name' => 'Italeri'],
            ['name' => 'KP MODEL'],
            ['name' => 'LeadWarrior'],
            ['name' => 'Master Box'],
            ['name' => 'Meng'],
            ['name' => 'Merit'],
            ['name' => 'MiniArt'],
            ['name' => 'Mirror Models'],
            ['name' => 'Modelcollect'],
            ['name' => 'ModelSvit'],
            ['name' => 'Must Have!'],
            ['name' => 'Panda'],
            ['name' => 'Revell'],
            ['name' => 'Riich Models'],
            ['name' => 'Roden'],
            ['name' => 'Rye Field Model'],
            ['name' => 'Smer'],
            ['name' => 'Stalingrad'],
            ['name' => 'TAKOM'],
            ['name' => 'Tamiya'],
            ['name' => 'Thunder Models'],
            ['name' => 'Tristar'],
            ['name' => 'Trumpeter'],
            ['name' => 'UM'],
            ['name' => 'Verlinden'],
            ['name' => 'Vision Models'],
            ['name' => 'Vulkan'],
            ['name' => 'Xact'],
            ['name' => 'Xuntong Models'],
            ['name' => 'Восточный экспресс'],
            ['name' => 'Звезда'],
            ['name' => 'Мир Моделей'],
            ['name' => 'Моделист'],
            ['name' => 'Танк'],
            ['name' => 'Южный фронт'],
        ]);
    }
}
