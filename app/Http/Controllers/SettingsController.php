<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Models\Payment;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::all()->pluck('setting_value', 'setting_key');
        $payments = Payment::with(['invoice', 'client'])->latest()->paginate(10);
        return view('settings.index', compact('settings', 'payments'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'gst_rate' => 'required|numeric|min:0|max:1',
            'invoice.prefix' => 'required|string|max:10',
            'invoice.next_number' => 'required|integer|min:1',
            'invoice.default_template' => 'required|string',
            'company.name' => 'required|string|max:255',
            'company.address' => 'required|string|max:500'
        ]);

        foreach ($validated as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subKey => $subValue) {
                    Settings::set("$key.$subKey", $subValue);
                }
            } else {
                Settings::set($key, $value);
            }
        }

        return redirect()->route('settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}