<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../utils/init.php');
?>

<?php function drawHeader() { ?>
    <!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>HelpDesk - Trouble Tickets</title>
        <link rel="stylesheet" href="../css/style.css">
        <script src="../javascript/script.js" defer></script>
    </head>
    <body>
        <header>
            <h1><a href = "/pages/index.php">HelpDesk</a></h1>
        </header>
        <main>
<?php } ?>