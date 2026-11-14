<?php

namespace App\Services;

use App\Models\Setting;

class HomePageImages
{
    public const FIELDS = [
        'header_image' => ['label' => 'Header image', 'default' => 'hero-bg.png'],
        'block_1_image' => ['label' => 'Block 1 image', 'default' => 'how-it-works.png'],
        'block_2_image' => ['label' => 'Block 2 image', 'default' => 'why-blueocean.png'],
        'block_3_image' => ['label' => 'Block 3 image', 'default' => 'trusted-professionals.png'],
        'bottom_image' => ['label' => 'Bottom image', 'default' => 'relaxing.jpg'],
    ];

    public function urls(): array
    {
        $settings = Setting::whereIn('param_key', array_map(
            fn ($field) => 'home_' . $field, array_keys(self::FIELDS)
        ))->pluck('param_value', 'param_key');

        $images = [];
        foreach (self::FIELDS as $field => $definition) {
            $path = $settings->get('home_' . $field);
            $images[$field] = $path
                ? asset(rtrim(config('custom.upload.url'), '/') . '/' . $path)
                : asset('assets/img/' . $definition['default']);
        }

        return $images;
    }
}
