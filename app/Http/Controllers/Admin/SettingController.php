<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        return view('admin.modules.setting.index', [
            'settings' => Setting::query()
                ->orderBy('param_key')
                ->paginate(config('custom.db.per_page')),
        ]);
    }

    public function edit(Setting $setting): View
    {
        return view('admin.modules.setting.edit', [
            'setting' => $setting,
        ]);
    }

    public function update(Request $request, Setting $setting): RedirectResponse
    {
        $validated = $request->validate([
            'param_value' => ['required', 'string', 'max:55'],
        ]);

        $setting->update($validated);

        return redirect()
            ->route('admin.settings.edit', $setting)
            ->with('status', 'Setting updated successfully.');
    }
}
