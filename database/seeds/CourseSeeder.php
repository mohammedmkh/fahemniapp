<?php

use Illuminate\Database\Seeder;
use App\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Course = [
            [
                'id' => 1,
                'name_en' => 'MATH',
                'name_ar' => 'رياضيات',
            ],
            [
                'id' => 2,
                'name_en' => 'Arabic',
                'name_ar' => 'عربي',
            ],
        ];
        Course::insert($Course);
    }
}
