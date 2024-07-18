<?php
return [
    'reader' => 'XMLReader',
    'writer' => 'MySQLWriter',
    'xmlFilePath' => __DIR__ . '\..\input\feed.xml',
    'dbConfig' => [
        'servername' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname' => 'feed',
    ],
    'sqliteFilePath' => __DIR__ . '\..\input\database.sqlite',
    'mongoConfig' => [
        'uri' => 'mongodb://localhost:27017',
        'dbname' => 'feed'
    ],
];
