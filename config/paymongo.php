<?php

return [
    'api_key' => env('PAYMONGO_PUBLIC_KEY'),
    'api_secret' => env('PAYMONGO_SECRET_KEY'),
    'checkout_url' => 'https://api.paymongo.com/v1/checkout_sessions',
];