<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../utils/init.php');

    if(!isset($_SESSION['username'])){
      header("Location:/index.php");
    }
    
require_once(__DIR__ . '/../templates/header.tpl.php');
require_once(__DIR__ . '/../templates/footer.tpl.php');

drawHeader();
?>

  <div class="ticket-form">
    <h2>Create new FAQ</h2>
      <form action="/actions/processar_faq.php" method="post"> <!-- Ação e método do formulário, a ser processado no servidor -->
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <input type="submit" value="Submit">
      </form>
  </div>
 
<?php
    drawFooter();
?>