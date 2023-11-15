<?php
require_once(__DIR__ . '/../utils/init.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/ticket.class.php');

$ticketId = $_POST['ticketId'];
$newDepartmentId = intval($_POST['newDepartmentId']);


// Check if the required parameters are set
if (isset($ticketId, $newDepartmentId)) {
    // Call the updateTicketDepartment function
    $result = Ticket::updateTicketDepartment($ticketId, $newDepartmentId);

    if ($result) {
        echo 'success';
    } else {
        echo 'failure';
    }
} else {
    echo 'Missing parameters';
}

?>

