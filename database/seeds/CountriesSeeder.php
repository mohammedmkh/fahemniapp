<?php

use Illuminate\Database\Seeder;
use App\Country;
class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = [
            [
                'id'    => 1,
                'name_en' => 'palestine',
                'name_ar' => 'فلسطين',

            ],
            [
                'id'    => 2,
                'name_en' => 'EGYPT',
                'name_ar' => 'مصر',
            ],
        ];

     Country::insert($country);
    }
}
