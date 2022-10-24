<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'country_create',
            ],
            [
                'id'    => 18,
                'title' => 'country_edit',
            ],
            [
                'id'    => 19,
                'title' => 'country_show',
            ],
            [
                'id'    => 20,
                'title' => 'country_delete',
            ],
            [
                'id'    => 21,
                'title' => 'country_access',
            ],
            [
                'id'    => 22,
                'title' => 'level_create',
            ],
            [
                'id'    => 23,
                'title' => 'level_edit',
            ],
            [
                'id'    => 24,
                'title' => 'level_show',
            ],
            [
                'id'    => 25,
                'title' => 'level_delete',
            ],
            [
                'id'    => 26,
                'title' => 'level_access',
            ],
            [
                'id'    => 27,
                'title' => 'universite_create',
            ],
            [
                'id'    => 28,
                'title' => 'universite_edit',
            ],
            [
                'id'    => 29,
                'title' => 'universite_show',
            ],
            [
                'id'    => 30,
                'title' => 'universite_delete',
            ],
            [
                'id'    => 31,
                'title' => 'universite_access',
            ],
            [
                'id'    => 32,
                'title' => 'course_create',
            ],
            [
                'id'    => 33,
                'title' => 'course_edit',
            ],
            [
                'id'    => 34,
                'title' => 'course_show',
            ],
            [
                'id'    => 35,
                'title' => 'course_delete',
            ],
            [
                'id'    => 36,
                'title' => 'course_access',
            ],
            [
                'id'    => 37,
                'title' => 'tutors_course_create',
            ],
            [
                'id'    => 38,
                'title' => 'tutors_course_edit',
            ],
            [
                'id'    => 39,
                'title' => 'tutors_course_show',
            ],
            [
                'id'    => 40,
                'title' => 'tutors_course_delete',
            ],
            [
                'id'    => 41,
                'title' => 'tutors_course_access',
            ],
            [
                'id'    => 42,
                'title' => 'price_create',
            ],
            [
                'id'    => 43,
                'title' => 'price_edit',
            ],
            [
                'id'    => 44,
                'title' => 'price_show',
            ],
            [
                'id'    => 45,
                'title' => 'price_delete',
            ],
            [
                'id'    => 46,
                'title' => 'price_access',
            ],
            [
                'id'    => 47,
                'title' => 'wallet_create',
            ],
            [
                'id'    => 48,
                'title' => 'wallet_edit',
            ],
            [
                'id'    => 49,
                'title' => 'wallet_show',
            ],
            [
                'id'    => 50,
                'title' => 'wallet_delete',
            ],
            [
                'id'    => 51,
                'title' => 'wallet_access',
            ],
            [
                'id'    => 52,
                'title' => 'review_create',
            ],
            [
                'id'    => 53,
                'title' => 'review_edit',
            ],
            [
                'id'    => 54,
                'title' => 'review_show',
            ],
            [
                'id'    => 55,
                'title' => 'review_delete',
            ],
            [
                'id'    => 56,
                'title' => 'review_access',
            ],
            [
                'id'    => 57,
                'title' => 'vaforite_create',
            ],
            [
                'id'    => 58,
                'title' => 'vaforite_edit',
            ],
            [
                'id'    => 59,
                'title' => 'vaforite_show',
            ],
            [
                'id'    => 60,
                'title' => 'vaforite_delete',
            ],
            [
                'id'    => 61,
                'title' => 'vaforite_access',
            ],
            [
                'id'    => 62,
                'title' => 'conversation_create',
            ],
            [
                'id'    => 63,
                'title' => 'conversation_edit',
            ],
            [
                'id'    => 64,
                'title' => 'conversation_show',
            ],
            [
                'id'    => 65,
                'title' => 'conversation_delete',
            ],
            [
                'id'    => 66,
                'title' => 'conversation_access',
            ],
            [
                'id'    => 67,
                'title' => 'setting_create',
            ],
            [
                'id'    => 68,
                'title' => 'setting_edit',
            ],
            [
                'id'    => 69,
                'title' => 'setting_show',
            ],
            [
                'id'    => 70,
                'title' => 'setting_delete',
            ],
            [
                'id'    => 71,
                'title' => 'setting_access',
            ],
            [
                'id'    => 72,
                'title' => 'help_create',
            ],
            [
                'id'    => 73,
                'title' => 'help_edit',
            ],
            [
                'id'    => 74,
                'title' => 'help_show',
            ],
            [
                'id'    => 75,
                'title' => 'help_delete',
            ],
            [
                'id'    => 76,
                'title' => 'help_access',
            ],
            [
                'id'    => 77,
                'title' => 'booking_create',
            ],
            [
                'id'    => 78,
                'title' => 'booking_edit',
            ],
            [
                'id'    => 79,
                'title' => 'booking_show',
            ],
            [
                'id'    => 80,
                'title' => 'booking_delete',
            ],
            [
                'id'    => 81,
                'title' => 'booking_access',
            ],
            [
                'id'    => 82,
                'title' => 'devicetoken_create',
            ],
            [
                'id'    => 83,
                'title' => 'devicetoken_edit',
            ],
            [
                'id'    => 84,
                'title' => 'devicetoken_show',
            ],
            [
                'id'    => 85,
                'title' => 'devicetoken_delete',
            ],
            [
                'id'    => 86,
                'title' => 'devicetoken_access',
            ],
            [
                'id'    => 87,
                'title' => 'notification_create',
            ],
            [
                'id'    => 88,
                'title' => 'notification_edit',
            ],
            [
                'id'    => 89,
                'title' => 'notification_show',
            ],
            [
                'id'    => 90,
                'title' => 'notification_delete',
            ],
            [
                'id'    => 91,
                'title' => 'notification_access',
            ],
            [
                'id'    => 92,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
