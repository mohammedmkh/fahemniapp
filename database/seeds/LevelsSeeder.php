<?php

use Illuminate\Database\Seeder;
use App\Level;
class LevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Level = [
            [
                'id' => 1,
                'name_en' => 'IT',
                'name_ar' => 'تكنولوحيا معلومات',
            ],

        ];
        Level::insert($Level);
    }
}
