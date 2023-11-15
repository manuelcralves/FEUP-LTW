<?php
require_once(__DIR__ . '/../utils/init.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/task.class.php');

$taskId = $_POST['taskId'];
$co= true;

$result = Task::closeTask($taskId, $co);

if ($result) {
    echo 'success';
} else {
    echo 'failure';
}
?>