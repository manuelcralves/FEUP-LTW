<?php
  declare(strict_types=1);

  require_once(__DIR__ . '/../utils/init.php');
  
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/ticket.class.php');
  
  $hashtags = isset($_POST['hashtags']) ? $_POST['hashtags'] : []; // Array of hashtags associated with the ticket
  
  $ticket_id = Ticket::create($dbh, $_POST['department'], $_POST['title'], $_POST['description'], intval(getUserID()), $hashtags);
  
  if ($ticket_id) {
    header("Location: ../pages/ticketpage.php?id=$ticket_id");
  } else {
    header('Location: ../ticketpage.php');
  }
  
?>