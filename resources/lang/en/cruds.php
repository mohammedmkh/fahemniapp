<?php

return [
    'userManagement' => [
        'title'          => 'User management',
        'title_singular' => 'User management',
    ],
    'permission' => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role' => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'title'              => 'Title',
            'title_helper'       => ' ',
            'permissions'        => 'Permissions',
            'permissions_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'user' => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'name'                     => 'Name',
            'name_helper'              => ' ',
            'email'                    => 'Email',
            'email_helper'             => ' ',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => ' ',
            'password'                 => 'Password',
            'password_helper'          => ' ',
            'roles'                    => 'Roles',
            'roles_helper'             => ' ',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
            'verify'                   => 'Verfiy',
            'verify_helper'            => ' ',
            'phone'                    => 'Phone',
            'phone_helper'             => ' ',
            'sex'                      => 'Sex',
            'sex_helper'               => ' ',
            'age'                      => 'Age',
            'age_helper'               => ' ',
            'country'                  => 'Country',
            'country_helper'           => ' ',
            'lat'                      => 'Lat',
            'lat_helper'               => ' ',
            'long'                     => 'Long',
            'long_helper'              => ' ',
            'level'                    => 'Level',
            'level_helper'             => ' ',
            'university'               => 'University',
            'university_helper'        => ' ',
            'bio'                      => 'Bio',
            'bio_helper'               => ' ',
        ],
    ],
    'country' => [
        'title'          => 'Countries',
        'title_singular' => 'Country',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name_ar'           => 'Name Arabic',
            'name_ar_helper'    => ' ',
            'name_en'           => 'Name English',
            'name_en_helper'    => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'level' => [
        'title'          => 'Levels',
        'title_singular' => 'Level',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name_ar'           => 'Name Arabic',
            'name_ar_helper'    => ' ',
            'name_en'           => 'Name English',
            'name_en_helper'    => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'universite' => [
        'title'          => 'Universites',
        'title_singular' => 'Universite',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name_en'           => 'Name Englsh',
            'name_en_helper'    => ' ',
            'name_ar'           => 'Name Arabic',
            'name_ar_helper'    => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'course' => [
        'title'          => 'Courses',
        'title_singular' => 'Course',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name_ar'           => 'Name Arabic',
            'name_ar_helper'    => ' ',
            'name_en'           => 'Name English',
            'name_en_helper'    => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'tutorsCourse' => [
        'title'          => 'Tutors Courses',
        'title_singular' => 'Tutors Course',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'user'              => 'User',
            'user_helper'       => ' ',
            'course'            => 'Course',
            'course_helper'     => ' ',
            'grade'             => 'Grade',
            'grade_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'price' => [
        'title'          => 'Prices',
        'title_singular' => 'Price',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'num_std'           => 'Num Stdudents',
            'num_std_helper'    => ' ',
            'hours'             => 'Hours',
            'hours_helper'      => ' ',
            'price'             => 'Price',
            'price_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'wallet' => [
        'title'          => 'Wallet',
        'title_singular' => 'Wallet',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'user'              => 'User',
            'user_helper'       => ' ',
            'amount'            => 'Amount',
            'amount_helper'     => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'review' => [
        'title'          => 'Reviews',
        'title_singular' => 'Review',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'reviewer'          => 'Reviewer',
            'reviewer_helper'   => ' ',
            'reviewed'          => 'Reviewed',
            'reviewed_helper'   => ' ',
            'type'              => 'Type',
            'type_helper'       => ' ',
            'review'            => 'Review',
            'review_helper'     => ' ',
            'note'              => 'Note',
            'note_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'vaforite' => [
        'title'          => 'Vaforite',
        'title_singular' => 'Vaforite',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'user'              => 'User',
            'user_helper'       => ' ',
            'tutor'             => 'Tutor',
            'tutor_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'conversation' => [
        'title'          => 'Conversations',
        'title_singular' => 'Conversation',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'user'              => 'User',
            'user_helper'       => ' ',
            'tutor'             => 'Tutor',
            'tutor_helper'      => ' ',
            'accept'            => 'Accept',
            'accept_helper'     => ' ',
            'end_conv'          => 'End Conversation',
            'end_conv_helper'   => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'setting' => [
        'title'          => 'Settings',
        'title_singular' => 'Setting',
        'fields'         => [
            'id'                   => 'ID',
            'id_helper'            => ' ',
            'text_policy'          => 'Text Policy',
            'text_policy_helper'   => ' ',
            'tex_policy_ar'        => 'Tex Policy Arabic',
            'tex_policy_ar_helper' => ' ',
            'aboutus_en'           => 'About us English',
            'aboutus_en_helper'    => ' ',
            'aboutus_ar'           => 'About us Arabic',
            'aboutus_ar_helper'    => ' ',
            'terms_ar'             => 'Terms Arabic',
            'terms_ar_helper'      => ' ',
            'terms_en'             => 'Terms English',
            'terms_en_helper'      => ' ',
            'created_at'           => 'Created at',
            'created_at_helper'    => ' ',
            'updated_at'           => 'Updated at',
            'updated_at_helper'    => ' ',
            'deleted_at'           => 'Deleted at',
            'deleted_at_helper'    => ' ',
        ],
    ],
    'help' => [
        'title'          => 'Help',
        'title_singular' => 'Help',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'question_ar'        => 'Question Arabic',
            'question_ar_helper' => ' ',
            'question_en'        => 'Question Englihs',
            'question_en_helper' => ' ',
            'answer_en'          => 'Answer English',
            'answer_en_helper'   => ' ',
            'answer_ar'          => 'Answer Arabic',
            'answer_ar_helper'   => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'booking' => [
        'title'          => 'Booking',
        'title_singular' => 'Booking',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'user'              => 'User',
            'user_helper'       => ' ',
            'tutor'             => 'Tutor',
            'tutor_helper'      => ' ',
            'date'              => 'Date',
            'date_helper'       => ' ',
            'time'              => 'Time',
            'time_helper'       => ' ',
            'payed'             => 'Payed',
            'payed_helper'      => ' ',
            'status'            => 'Status',
            'status_helper'     => ' ',
            'price'             => 'Price Id',
            'price_helper'      => ' ',
            'total'             => 'Total',
            'total_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'devicetoken' => [
        'title'          => 'Devicetokens',
        'title_singular' => 'Devicetoken',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => ' ',
            'user'                => 'User',
            'user_helper'         => ' ',
            'device_type'         => 'Device Type',
            'device_type_helper'  => ' ',
            'device_token'        => 'Device Token',
            'device_token_helper' => ' ',
            'created_at'          => 'Created at',
            'created_at_helper'   => ' ',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => ' ',
            'deleted_at'          => 'Deleted at',
            'deleted_at_helper'   => ' ',
        ],
    ],
    'notification' => [
        'title'          => 'Notifications',
        'title_singular' => 'Notification',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'user'               => 'User',
            'user_helper'        => ' ',
            'action_type'        => 'Action Type',
            'action_type_helper' => ' ',
            'actionid'           => 'Action id',
            'actionid_helper'    => ' ',
            'action'             => 'Action',
            'action_helper'      => ' ',
            'reed'               => 'Reed',
            'reed_helper'        => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
];
