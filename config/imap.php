<?php

return [
    'default' => env('IMAP_DEFAULT_ACCOUNT', 'default'),

    'accounts' => [
        'default' => [
            'host'          => env('IMAP_HOST', 'imap.hostinger.com'),
            'port'          => env('IMAP_PORT', 993),
            'encryption'    => env('IMAP_ENCRYPTION', 'ssl'),
            'validate_cert' => false,
            'username'      => env('IMAP_USERNAME', 'automatic@sistemaherbdelux.com'),
            'password'      => env('IMAP_PASSWORD', 'Rian@100'),
            'protocol'      => 'imap'
        ],
    ],

    'options' => [
        'delimiter'   => '/',
        'fetch' => 0,
        'fetch_order' => 'desc',
        'dispositions' => [
            'attachment',
            'inline',
        ],
    ],
];