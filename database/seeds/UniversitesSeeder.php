<?php

use Illuminate\Database\Seeder;
use App\Universite;
class UniversitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Universite = [
            [
                'id' => 1,
                'name_en' => 'islamic university',
                'name_ar' => 'الجامعة الإسلامية',
            ],

        ];
        Universite::insert($Universite);
    }
}
