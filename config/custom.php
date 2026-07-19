<?php

return [

    'google_maps_api_key' => env('GOOGLE_MAPS_API_KEY'),
    
    'stripe_public_key' => env('STRIPE_PUBLIC_KEY'),
    'stripe_secret_key' => env('STRIPE_SECRET_KEY'),

    'sms_api_url' => env('SMS_API_URL'),
    'sms_api_key' => env('SMS_API_KEY'),
    'sms_sender' => env('SMS_SENDER'),

    'db' => [
        'per_page' => 25
    ],
    'upload' => [
        'url' => env('DOWNLOAD_URL', '/storage/'),
        'disk' => env('STORAGE_DISK', 'public_uploads'),
        'post_path' => 'posts',
        'treatment_path' => 'treatments',
        'treatment_category_path' => 'treatment-categories',
        'user_path' => 'users',
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
