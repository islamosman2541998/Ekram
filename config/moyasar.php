<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Moyasar Secret API Key
    |--------------------------------------------------------------------------
    |
    | Used for server-side API calls (verify payments, refunds, etc.)
    | Set MOYASAR_API_KEY in your .env file
    |
    */

    'key' => env('MOYASAR_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Moyasar Publishable API Key
    |--------------------------------------------------------------------------
    |
    | Used for the payment form on the frontend
    | Set MOYASAR_PUBLISHABLE_KEY in your .env file
    |
    */

    'publishable_key' => env('MOYASAR_PUBLISHABLE_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    */

    'currency' => env('MOYASAR_CURRENCY', 'SAR'),

];