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
    <h2>Create new Department</h2>
      <form action="/actions/processar_department.php" method="post"> <!-- Ação e método do formulário, a ser processado no servidor -->
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <input type="submit" value="Submit">
      </form>
  </div>
 
<?php
    drawFooter();
?>