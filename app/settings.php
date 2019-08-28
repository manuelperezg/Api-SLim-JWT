<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'db' => [
            'host' => 'localhost',
            'dbname' => 'pruebas',
            'user' => 'root',
            'pass' => ''
        ],
        // jwt settings
        'jwt' => [
            'secret' => 'SPA861201DK4'
        ]
    ],
];
