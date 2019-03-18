<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    protected static $settingKeys = ['website_phone', 'website_email', 'website_title', 'website_hotline', 'website_address',
        'payment_info', 'email_templates'];

    /**
     * Get all settings
     *
     * @param bool $toArray
     * @return mixed
     */
    public static function getSettings($toArray = false)
    {
        $settings = self::pluck('setting_value', 'setting_key');

        if ($toArray) {
            return $settings->toArray();
        } else {
            return $settings;
        }
    }

    /**
     * Update setting from array
     *
     * @param $settings
     * @return bool
     */
    public static function updateSettings($settings)
    {
        if (!empty($settings)) {
            foreach (self::$settingKeys as $key) {
                if (isset($settings[$key])) {
                    $value = is_array($settings[$key]) ? json_encode($settings[$key]) : $settings[$key];
                    // Check setting is exit
                    $setting = self::where('setting_key', $key)->first();
                    if ($setting) {
                        self::where('id', $setting->id)->update(['setting_value' => $value]);
                    } else {
                        // Create setting
                        self::create([
                            'setting_value' => $value,
                            'setting_key' => $key
                        ]);
                    }
                }
            }
            return true;
        }

        return false;
    }
}
