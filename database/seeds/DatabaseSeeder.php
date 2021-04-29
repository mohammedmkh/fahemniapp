<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            OuathSeeder::class,
            CountriesSeeder::class,
            CourseSeeder::class,
            LevelsSeeder::class,
            UniversitesSeeder::class,

        ]);
    }
}
