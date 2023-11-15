<?php

require_once(__DIR__ . '/../utils/init.php');

if(!isset($_SESSION['username'])){
  header("Location:/index.php");
}

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/department.class.php');

require_once(__DIR__ . '/../templates/header.tpl.php');
require_once(__DIR__ . '/../templates/footer.tpl.php');
require_once(__DIR__ . '/../templates/department.tpl.php');

$department = Department::getDepartment($dbh, intval($_GET['id']));
$tickets = Ticket::getTicketsbyDepartment($dbh, intval($_GET['id']));

// Get all hashtags
require_once(__DIR__ . '/../database/hashtag.class.php');
$hashtags = Hashtag::getAll($dbh);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Filter by status
  $status = $_POST['status'];
  if ($status !== 'all') {
    $tickets = Ticket::filterByStatus($dbh, intval($_GET['id']), $status);
  }

  if (isset($_POST['hashtags']) && is_array($_POST['hashtags']) && count($_POST['hashtags']) > 0) {
    $hashtagIds = $_POST['hashtags'];

    // Create an empty array to store the filtered tickets
    $filteredTickets = $tickets;

    // Iterate through each hashtag ID
    foreach ($hashtagIds as $hashtagId) {
      // Get the tickets for the current hashtag ID
      $hashtagTickets = Ticket::filterByHashtag($dbh, intval($_GET['id']), $hashtagId);
      
      // Merge the tickets with the filteredTickets array
      $filteredTickets = array_intersect($hashtagTickets, $filteredTickets);
    }

    // If both filters are applied, use intersection to get common tickets
    if (!empty($filteredTickets)) {
       //Filter the tickets array with the filteredTickets array
      $tickets = array_intersect($filteredTickets, $tickets);
    } else {
      $tickets = [];
    }
  }
}



drawHeader();
drawDepartment($department, $tickets, $hashtags);
drawFooter();

?>
