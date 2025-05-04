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
        $payments = Payment::with(['invoice', 'client'])->latest()->paginate(10); // Paginate the payments
    
        return view('settings.index', compact('settings', 'payments'));
    }
    

    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            Settings::set($key, $value);
        }
        
        return redirect()->route('settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}