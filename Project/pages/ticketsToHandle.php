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
  <section class="tickets">
      <h2>Tickets Assign to You </h2> 

      <ul>
        <?php  
        require_once(__DIR__ . '/../actions/getAgent_tickets.php');
        if(count($tickets) == 0){
          echo "<h3>You have no tickets assign to you</h3>";
        }

        for($i = 0; $i < count($tickets); $i++) { 
        include_once("../database/department.class.php");
        $depart = Department::getName($tickets[$i]['id_department']);
        ?>
        <li>
          <div class="ticket" id="<?=$tickets[$i]['id']?>">
            <h3> <?=$tickets[$i]['title']?></h3>
            <p> <?=$tickets[$i]['description']?> </p>
            <p>-- <?=$tickets[$i]['ticket_status']?> --</p>
            <p> Department: <?=$depart?> </p>
            <a href="../pages/detailTicket.php?id=<?=$tickets[$i]['id']?>" class="button">Detalhes</a>
          </div>
        </li>
        <?php } ?>   
      </ul>
    </section>
  
<?php
  drawFooter();
?>