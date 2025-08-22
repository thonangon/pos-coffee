<?php

use App\Models\EmailSetting;
use App\Models\Exchange;
use App\Models\GlobalSetting;
use App\Models\LanguageSetting;
use App\Helper\Files;
use App\Models\OrderNumberSetting;
use App\Models\Package;
use App\Models\PaymentGatewayCredential;
use App\Models\PusherSetting;
use App\Models\Restaurant;
use App\Models\StorageSetting;
use App\Models\SuperadminPaymentGateway;
use App\Models\GlobalCurrency;
use App\Models\Currency;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

if (!function_exists('user')) {

    /**
     * Return current logged-in user
     */
    function user()
    {
        if (session()->has('user')) {
            return session('user');
        }


        session(['user' => auth()->user()]);

        return session('user');
    }
}

function customer()
{
    if (session()->has('customer')) {
        return session('customer');
    }

    return null;
}
