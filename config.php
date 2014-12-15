<?php

// DB

define('DSN', 'mysql:host=localhost;dbname=blog_app','root','root');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

// エラー表示

error_reporting(E_ALL & ~E_NOTICE);