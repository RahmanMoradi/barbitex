<?php
namespace App\Models\Webazin\Mexc\Exeptions;
return [
    '400' => 'Invalid parameter',
    '401' => 'Invalid signature, fail to pass the validation',
    '429' => 'Too many requests, rate limit rule is violated',
    '10072' => 'Invalid access key',
    '10073' => 'Invalid request time',
    '30000' => 'Trading is suspended for the requested symbol',
    '30001' => 'Current trading type (bid or ask) is not allowed',
    '30002' => 'Invalid trading amount, smaller than the symbol minimum trading amount',
    '30003' => 'Invalid trading amount, greater than the symbol maximum trading amount',
    '30004' => 'Insufficient balance',
    '30005' => 'Oversell error',
    '30010' => 'Price out of allowed range',
    '30016' => 'Market is closed',
    '30019' => 'Orders count over limit for batch processing',
    '30020' => 'Restricted symbol, API access is not allowed for the time being',
    '30021' => 'Invalid symbol',
];
