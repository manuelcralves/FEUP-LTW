<?php

require_once(__DIR__ . '/../utils/init.php');

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$userAgent = isAgent(getUserID());

?>