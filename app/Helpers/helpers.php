<?php

use App\Facades\Currency as CurrencyService;
use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use Illuminate\Support\Facades\Schema;

if (!function_exists('format_money')) {
    function format_money($amount, $code = null)
    {
        if (!is_numeric($amount)) {
            $amount = 0;
        }
        $currency = CurrencyService::get($code);
        $amount = $amount / $currency->exchange_rate;
        $amount = new Money($amount, new Currency($currency->code), true);
        $formattedAmount = $amount->format(null, null);
        return $formattedAmount;
    }
}

if (!function_exists('convert_currency')) {
    function convert_currency($amount, $currency = null)
    {
        $currency = $currency ?? CurrencyService::getActive();
        return round($amount / $currency->exchange_rate, 2);
    }
}

if (!function_exists('currency_code')) {
    function currency_code()
    {
        return CurrencyService::code();
    }
}

if (!function_exists('placeholder_image')) {
    function placeholder_image()
    {
        return asset(config('app.placeholder_image'));
    }
}

if (!function_exists('placename')) {
    function placename($region)
    {
        if ($region && str_contains($region, '_')) {
            $flag = explode('_', $region);
            return mb_strtolower(end($flag));
        }
    }
}

if (!function_exists('get_percent')) {
    function get_percent($max, $min)
    {
        return ceil(($max - $min) / $max * 100);
    }
}

if (!function_exists('__lang')) {
    function __lang($key, $replace = [])
    {
        try {
            // Read from JSON file
            $jsonPath = database_path('language.json');
            if (file_exists($jsonPath)) {
                $translations = json_decode(file_get_contents($jsonPath), true);
                $locale = app()->getLocale();
                
                // Navigate through nested keys (e.g., 'emails.verify_email.subject')
                $keys = explode('.', $key);
                $value = $translations;
                
                foreach ($keys as $keyPart) {
                    if (isset($value[$keyPart])) {
                        $value = $value[$keyPart];
                    } else {
                        // Key not found, fallback to Laravel's translator
                        return __($key, $replace);
                    }
                }
                
                // Get localized value
                if (is_array($value) && isset($value[$locale])) {
                    $text = $value[$locale];
                    
                    // Handle replacements
                    foreach ($replace as $search => $replacement) {
                        $text = str_replace(':'.$search, $replacement, $text);
                    }
                    
                    return $text;
                }
            }
            
            // Fallback to Laravel's built-in translator
            return __($key, $replace);
        } catch (\Exception $e) {
            // If JSON reading fails, fallback to Laravel's translator
            return __($key, $replace);
        }
    }
}
