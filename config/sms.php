<?php

return [
    'smsir' => [
        'api_key' => env('SMSIR_API_KEY', ''),
        'template_id' => env('SMSIR_TEMPLATE_ID', ''),
        'code_param' => env('SMSIR_CODE_PARAM', 'Code'),
    ],
];
