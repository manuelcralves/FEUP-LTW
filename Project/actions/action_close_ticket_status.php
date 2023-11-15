<?php
require_once(__DIR__ . '/../utils/init.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/ticket.class.php');

$ticketId = $_POST['ticketId'];
$assig = 'Closed';

$result = Ticket::closeTicket($ticketId, $assig);

if ($result) {
    echo 'success';
} else {
    echo 'failure';
}
?>