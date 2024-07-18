<?php
return [
    'reader' => 'XMLReader', // or 'JSONReader', 'MySQLReader', etc.
    'writer' => 'MySQLWriter', // or 'SQLiteWriter', 'MongoDBWriter', etc.
    'xmlFilePath' => 'input/feed.xml',
    'dbConfig' => [
        'servername' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname' => 'feed',
    ],
    'sqliteFilePath' => 'input/database.sqlite',
    'mongoConfig' => [
        'uri' => 'mongodb://localhost:27017',
        'dbname' => 'feed'
    ],
];
