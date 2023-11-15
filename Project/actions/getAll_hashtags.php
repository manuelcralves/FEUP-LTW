<?php


require_once(__DIR__ . '/../utils/init.php');

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/hashtag.class.php');

$hashtags = Hashtag::getAll($dbh);

?>