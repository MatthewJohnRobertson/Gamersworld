<?php

return [
    'mode' => 'sandbox',
    'sandbox' => [
        'client_id' => 'AeLf1N1M4eCgURPqzkkFM4OSC4264V4p9QE7NejR9esaEqm10DTBRwcPwWbV0V2gise59xv7di44K3AF',
        'client_secret' => 'EEpywElEMoozrOQT_HROEwYXe6kSpmplObD_b5E2RiG5aZWUQnvtlstkkx6HQj6nyqbkSWpV82o5RvlI',
        'app_id' => '',
    ],
    'live' => [
        'client_id' => env('PAYPAL_LIVE_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_LIVE_CLIENT_SECRET', ''),
        'app_id' => '',
    ],
    'payment_action' => 'Sale',
    'currency' => 'AUD',
    'notify_url' => '',
    'locale' => 'en_AU',
    'validate_ssl' => true,
    'webhook_id' => ''
];
