<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'system_settings';

    protected $fillable = [
        'setting_key',
        'setting_value',
        'is_public',
    ];

    public $timestamps = false; // Optional: if your table doesn't have created_at/updated_at

    /**
     * Retrieve a setting by key.
     */
    public static function get(string $key, $default = null)
    {
        $setting = self::where('setting_key', $key)->first();
        return $setting ? $setting->setting_value : $default;
    }

    /**
     * Set or update a setting.
     */
    public static function set(string $key, $value, bool $isPublic = false)
    {
        return self::updateOrCreate(
            ['setting_key' => $key],
            ['setting_value' => $value, 'is_public' => $isPublic]
        );
    }
}
