<?php
require_once(__DIR__ . '/../utils/init.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$userId = $_POST['userId'];
$bl = true;

$result = userToAdmin($userId, $bl);

if ($result) {
    echo 'success';
} else {
    echo 'failure';
}
?>