<?php
require_once(__DIR__ . '/../utils/init.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$userId = $_POST['userId'];
$newDepartmentId = intval($_POST['newDepartmentId']);


// Check if the required parameters are set
if (isset($userId, $newDepartmentId)) {
    // Call the updateUserDepartment function
    $result = updateUserDepartment($userId, $newDepartmentId);

    if ($result) {
        echo 'success';
    } else {
        echo 'failure';
    }
} else {
    echo 'Missing parameters';
}

?>