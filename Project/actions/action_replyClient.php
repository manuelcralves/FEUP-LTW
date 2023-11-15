<?php
require_once(__DIR__ . '/../utils/init.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/reply.class.php');

$ticketId = $_POST['ticketId'];
$userId = getUserID();
$replyText = $_POST['reply'];

$result = Reply::replyClient($ticketId, $userId, $replyText);

if ($result) {
    echo 'success';
} else {
    echo 'failure';
}
?>
