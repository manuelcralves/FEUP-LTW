<?php


require_once(__DIR__ . '/../utils/init.php');

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/ticket.class.php');

$tickets = Ticket::getTicketsbyUser($dbh, getUserID());

?>