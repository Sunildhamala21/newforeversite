<?php

namespace App\Helpers;

use App\Models\SiteSetting;

class Setting
{
    private static $setting;

    private static $instance;

    private function __construct() {}

    public static function __init()
    {

        if (! isset(self::$setting)) {

            self::$instance = new self;
            self::$instance->_loadSetting();
        }

        // return self::$setting;
    }

    public static function get($name, $default = false)
    {
        if (! isset(self::$setting)) {
            self::__init();
        }

        $name = trim($name);

        if (array_key_exists($name, self::$setting)) {
            return self::$setting[$name];
        }

        // if not autoloaded get it from database
        $query = SiteSetting::select('value')->where('name', $name)->first();

        if (! $query) {
            return $default;
        }

        if (is_object($query)) {

            $value = $query->value;

            return self::$instance->_maybe_unserialize($value);

        } else {
            return $default;
        }

    }

    public static function set($option, $value = '', $autoload = 1)
    {
        if (! isset(self::$setting)) {
            self::__init();
        }

        $option = trim($option);

        if (empty($option)) {
            return false;
        }

        if (self::get($option) === false) {

            $value = self::$instance->_maybe_serialize($value);
            $autoload = ($autoload === 0) ? 0 : 1;

            $query = SiteSetting::updateOrCreate(
                ['name' => $option],
                ['name' => $option, 'value' => $value, 'autoload' => $autoload]
            );

            if ($query) {
                return true;
            } else {
                return false;
            }

        }
        // else
        // show_error('The option <b>"'.$option.'"</b> already exists.');
    }

    public static function update($option, $newvalue)
    {
        if (! isset(self::$setting)) {
            self::__init();
        }

        $option = trim($option);

        if (empty($option)) {
            return false;
        }

        $oldvalue = self::get($option);

        if ($newvalue === $oldvalue) {
            return false;
        }

        if ($oldvalue === false) {
            return self::set($option, $newvalue);
        }

        $newvalue = self::$instance->_maybe_serialize($newvalue);

        $query = SiteSetting::where('name', $option)->update(['value' => $newvalue]);

        if ($query) {
            // refresh the options
            self::$instance->_loadSetting();

            return true;
        } else {
            return false;
        }
    }

    private function _loadSetting()
    {
        $opt = SiteSetting::select('name', 'value')->where('autoload', '1')->get();

        $setting = [];
        if (count($opt) > 0) {
            foreach ($opt as $o) {
                $setting[$o->name] = $this->_maybe_unserialize($o->value);
            }
        }

        self::$setting = $setting;

    }

    private function _maybe_serialize($data)
    {
        if (is_array($data) || is_object($data)) {
            return serialize($data);
        }

        if ($this->_is_serialized($data)) {
            return serialize($data);
        }

        return $data;
    }

    private function _maybe_unserialize($original)
    {
        if ($this->_is_serialized($original)) { // don't attempt to unserialize data that wasn't serialized going in
            return @unserialize($original);
        }

        return $original;
    }

    private function _is_serialized($data)
    {
        // if it isn't a string, it isn't serialized
        if (! is_string($data)) {
            return false;
        }
        $data = trim($data);

        if ($data == 'N;') {
            return true;
        }
        $length = strlen($data);
        if ($length < 4) {
            return false;
        }
        if ($data[1] !== ':') {
            return false;
        }
        $lastc = $data[$length - 1];
        if ($lastc !== ';' && $lastc !== '}') {
            return false;
        }
        $token = $data[0];
        switch ($token) {
            case 's':
                if ($data[$length - 2] !== '"') {
                    return false;
                }
            case 'a':
            case 'O':
                return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b':
            case 'i':
            case 'd':
                return (bool) preg_match("/^{$token}:[0-9.E-]+;\$/", $data);
        }

        return false;
    }

    public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public static function getHomePageImage($image_name = null)
    {
        if ($image_name) {
            return url('storage/home-page').'/'.$image_name;
        }

        return config('constants.default_image_url');
    }

    public static function getSiteSettingImage($image_name = null)
    {
        if ($image_name) {
            return url('storage/site-settings').'/'.$image_name;
        }

        return config('constants.default_image_url');
    }
}
