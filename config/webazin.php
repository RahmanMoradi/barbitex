<?php

return [
    'binance' => [
        'api_key' => env('BINANCE_API_KEY'),
        'secret_key' => env('BINANCE_SECRET_KEY')
    ],
    'kucoin' => [
        'api_key' => env('KUCOIN_API_KEY'),
        'secret_key' => env('KUCOIN_SECRET_KEY'),
        'password' => env('KUCOIN_PASSWORD')
    ],
    'mexc' => [
        'key' => env('MEXC_KEY'),
        'secret' => env('MEXC_SECRET')
    ],
    'perfectmoney' => [
        'account_id' => 'eyJpdiI6IlppaE16ZzUyRE9sYmZSb1lCM3BvMmc9PSIsInZhbHVlIjoiVndVNWhHZm1pTGlPSTBSOUl5VXE3UT09IiwibWFjIjoiNmE4NTkxOWI1ZmY4YmYyMjc3YWJiYTgzMDBhNWU0YTgzODQwMTRjMTlkZjIwMjcwNzlkNWEyMzgzMTdlNTIxZSIsInRhZyI6IiJ9',
        'passphrase' => 'eyJpdiI6IkJ4cmJDR2lIbWNwalZBTzJ3azd6K2c9PSIsInZhbHVlIjoiZkkrV1psS1Z3VkFLRUZEempBK283U3NtdDk0WEFObnFkTVMyTUt4cytCaz0iLCJtYWMiOiJiNzQwMjMyZDMwNmIxMzVlY2QzNmIzYmM2MmNlNDgzZjM0MTY1ZTExMTdmMGFlODc4MDE5ODVmMTY3MzQyNDQ3IiwidGFnIjoiIn0=',
        'alt_passphrase' => 'eyJpdiI6IjdDYitjY1hIbUFnZlB5Zmh2SVpHRGc9PSIsInZhbHVlIjoiOUVGWXR3a0lPdUFTQjZpcjhLN0xQRXhLdWJ6UHpxMXpxZjhERlRhdkdPWT0iLCJtYWMiOiJkNzI0MGI2YWViMTcwMDUzNWNmNWQzYmU0ZTk5OWIyZDViNjY0NWFiYTNmNmQ1OTc5ZmEwNjVmYzNhZWQ5YjZmIiwidGFnIjoiIn0=',
        'merchant_id' => 'eyJpdiI6Im1HNXQ1NEEzUWpqOTNDTytHa3pQNXc9PSIsInZhbHVlIjoiWjFFTFVWWVdUVzc4am1QNUxua1BBVEwwNkkvY3o1d1BRWmtPVnFCS2xaMD0iLCJtYWMiOiJiZDA2ZWU3NDM3MjhhMTA4NTYwYjA1NjZjMDUxNmE4ODNkOGFiOWE0MTY1OTA1ZGFkYzY4ZjI0ZGEwYTVlZTZlIiwidGFnIjoiIn0=',
    ],
//    'binance'   => [
//        'api_key'    => '132SI9RJ3lK6KjoVE4pSA74rieNkzTO1yrSDhwrShdugy7YpDbJWHP7EjwaxYIgU' ,
//        'secret_key' => 'QIXTGSr9p7JBXtXJWdkBmeSqNoVIArVkkmx4Fgg0XzcArnUp4bQtHd6zznM0Y0cA'
//    ]
    'theme' => [
        'theme' => 'light',
        'sidebarCollapsed' => '',
        'navbarColor' => '',
        'menuType' => '',
        'navbarType' => '',
        'footerType' => '',
        'sidebarClass' => 'menu-expanded',
        'bodyClass' => '',
        'pageHeader' => '',
        'blankPage' => '',
        'blankPageClass' => '',
        'contentLayout' => '',
        'sidebarPositionClass' => '',
        'contentsidebarClass' => '',
        'mainLayoutType' => '',
    ],
    'tronGrid' => [
        'public_Key' => '1423d4fa-bb67-474a-ba64-e0b569d1bce4',
        'full_node_url' => 'https://api.trongrid.io',
//        'solidity_node_url' => 'https://api.trongrid.io',
        'solidity_node_url' => 'https://solidity.guildchat.io',
        'event_server_url' => 'https://api.trongrid.io',
    ],
    'bybit' => [
        'key' => env('BYBIT_KEY'),
        'secret' => env('BYBIT_SECRET')
    ],
    'inquiry' => [
        'default' => env('DEFAULT_INQUIRY_PROVIDER', 'jibit')
    ],
];
