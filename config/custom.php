<?php

return [

    'stripe_public_key' => env('STRIPE_PUBLIC_KEY'),
    'stripe_secret_key' => env('STRIPE_SECRET_KEY'),

    'text_local_api_username' => env('TEXTLOCAL_API_USERNAME'),
    'text_local_api_password' => env('TEXTLOCAL_API_PASSWORD'),
    'textlocal_sender_to_therapists' => env('TEXTLOCAL_SENDER_TO_THERAPISTS'),
    'text_local_test_number' => env('TEXTLOCAL_TEST_NUMBER', '07786206055'),


    'db' => [
        'per_page' => 50
    ],
    'download' => [
        'url' => env('DOWNLOAD_URL', '/storage/')
    ],
    'upload' => [
        'disk' => env('STORAGE_DISK', 'public_uploads'),
        'blog_path' => 'posts',
        'treatment_path' => 'treatments',
        'user_path' => 'users',
        'therapist_path' => 'therapists',
        'massage_locations_path' => 'mobileMassage',
        'job_application_path' => 'job-applications',
        'editor_image_path' => 'ckeditorimages',
    ],
    'format' => [
        'date_short' => 'd/m/Y',
        'date_long' => 'd M Y',
        'time' => 'H:i',
        'date_time' => 'd/m/Y H:i',
    ],
    'booking_timeout' => env('BOOKING_TIMEOUT', 60),
];
