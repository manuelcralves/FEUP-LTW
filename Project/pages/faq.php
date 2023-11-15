<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/init.php');

    if(!isset($_SESSION['username'])){
      header("Location:/index.php");
    }
  require_once(__DIR__ . '/../templates/header.tpl.php');
  require_once(__DIR__ . '/../templates/footer.tpl.php');
  require_once(__DIR__ . '/../database/user.class.php');

  $isADMIN = isAdmin(getUserID());
  $isAGENT = isAgent(getUserID());

  drawHeader();
?>
  <section class="tickets">
      <h2>Frequently Asked Question (FAQ)
      <?php
      if($isADMIN==true || $isAGENT==true){
      ?>
      <a href="/pages/nova_faq.php" class="button">Add FAQ</a>
      <?php } ?> 
      </h2> 

      <ul>
        <?php  
        require_once(__DIR__ . '/../actions/getAll_faqs.php');
        if(count($faqs) == 0){
          echo "<h3>No FAQ</h3>";
        }
        for($i = 0; $i < count($faqs); $i++) { 
        ?>
        <li>
          <div class="ticket" id="<?=$faqs[$i]['id']?>">
            <h3> <?=$faqs[$i]['title']?></h3>
            <p> <?=$faqs[$i]['description']?> </p>
          </div>
        </li>
        <?php } ?>   
      </ul>
    </section>
  
<?php
  drawFooter();
?>

