<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Settings/Index', [
            'settings' => Setting::all()->pluck('value', 'key'),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_title' => 'required|string|max:255',
            'site_logo' => 'nullable|image|max:2048',
            'site_favicon' => 'nullable|image|max:1024',
        ]);

        Setting::updateOrCreate(['key' => 'site_title'], ['value' => $validated['site_title']]);

        if ($request->hasFile('site_logo')) {
            $oldLogo = Setting::where('key', 'site_logo')->first()?->value;
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $path = $request->file('site_logo')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'site_logo'], ['value' => $path]);
        }

        if ($request->hasFile('site_favicon')) {
            $oldFavicon = Setting::where('key', 'site_favicon')->first()?->value;
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }
            $path = $request->file('site_favicon')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'site_favicon'], ['value' => $path]);
        }

        return back()->with('status', 'Tetapan sistem telah dikemaskini.');
    }
}
