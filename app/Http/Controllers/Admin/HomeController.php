<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\HomePageImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Throwable;

class HomeController extends Controller
{
    public function edit(HomePageImages $images)
    {
        return view('admin.modules.home.edit', [
            'fields' => HomePageImages::FIELDS,
            'images' => $images->urls(),
        ]);
    }

    public function update(Request $request)
    {
        $rules = [];
        foreach (HomePageImages::FIELDS as $field => $definition) {
            $rules[$field] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'];
        }
        $request->validate($rules);

        $disk = Storage::disk(config('custom.upload.disk'));
        $uploaded = [];

        try {
            foreach (HomePageImages::FIELDS as $field => $definition) {
                if ($request->hasFile($field)) {
                    $path = $request->file($field)->store('home', config('custom.upload.disk'));
                    if (! $path) {
                        throw ValidationException::withMessages([$field => 'The image could not be uploaded. Please try again.']);
                    }
                    $uploaded[$field] = $path;
                }
            }

            DB::transaction(function () use ($uploaded) {
                foreach ($uploaded as $field => $path) {
                    Setting::updateOrCreate(['param_key' => 'home_' . $field], ['param_value' => $path]);
                }
            });
        } catch (Throwable $exception) {
            $disk->delete(array_values($uploaded));
            throw $exception;
        }

        return redirect()->route('admin.home.edit')->with('status', 'Home page images updated successfully.');
    }
}
