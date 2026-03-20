<?php

namespace App\Http\Controllers;
use App\Models\Setting;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function settings()
    {
        $setting = Setting::first(); // only 1 row
        return view('admin.themes.settings', compact('setting'));
    }

    public function saveSettings(Request $request)
    {
        $setting = Setting::first();

        if (!$setting) {
            $setting = new Setting();
        }

        // Logo Upload
        if ($request->hasFile('logo')) {
            $file = $request->logo;
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/products/'), $filename);
            $setting->logo = $filename;
        }

        // Color Save
        $setting->theme_color = $request->theme_color;

        $setting->save();

        return back()->with('success', 'Settings Saved Successfully');
    }
}
