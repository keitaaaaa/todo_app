<?php

// DB(clearDB)

// define('DSN', 'mysql:host=us-cdbr-iron-east-01.cleardb.net;dbname=heroku_1d771801b9c601c;charset=utf8;');
// define('DB_USER', 'bc28633116647f');
// define('DB_PASSWORD', '04781d6e');

// DB(localhost)

define('DSN', 'mysql:host=localhost;dbname=todo_app;charset=utf8;');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

// DB(ロリポップ)

// define('DSN', 'mysql:host=mysql009.phy.lolipop.lan;dbname=LAA0564038-hotaiceweb;charset=utf8;');
// define('DB_USER', 'LAA0564038');
// define('DB_PASSWORD', 'shinod');

// エラー表示

error_reporting(E_ALL & ~E_NOTICE);
