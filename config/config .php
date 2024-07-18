<?php
return [
    'reader' => 'XMLReader',
    'writer' => 'MySQLWriter', // Change to 'SQLiteWriter' or 'MongoDBWriter' if using those
    'xmlFilePath' => __DIR__ . '/../input/feed.xml',
    'dbConfig' => [
        'servername' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname' => 'feed',
    ],
    'sqliteFilePath' => __DIR__ . '/../input/database.sqlite',
    'mongoConfig' => [
        'uri' => 'mongodb://localhost:27017',
        'dbname' => 'feed'
    ],
];
