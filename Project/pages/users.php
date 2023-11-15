<?php
  declare(strict_types=1);

  require_once(__DIR__ . '/../utils/init.php');
  require_once(__DIR__ . '/../database/department.class.php');

  if (!isset($_SESSION['username'])) {
    header("Location: /index.php");
    exit;
  }

  require_once(__DIR__ . '/../templates/header.tpl.php');

  drawHeader();
?>
<section class="tickets">
  <h2>Website Users</h2>

  <ul>
    <?php  
    require_once(__DIR__ . '/../actions/getAll_users.php');
    if (count($users) == 0) {
      echo "<h3>No users on this website</h3>";
    }

    for ($i = 0; $i < count($users); $i++) { 
      ?>
      <li>
        <div class="ticket" id="<?=$users[$i]['id']?>">
          <h3><?=$users[$i]['username']?></h3>
          <?php if ($users[$i]['is_admin'] && $users[$i]['is_agent']): ?>
            <p>Admin</p>
          <?php elseif ($users[$i]['is_agent']): ?>
            <?php
              $departmentId = $users[$i]['id_department'];
              $departmentName = Department::getDepartName($dbh, $departmentId);
            ?>
            <p>Agent</p>
            <p>Department: <?=$departmentName?></p>
          <?php else: ?>
            <p>Client</p>
          <?php endif; ?>
          <a href="../pages/userprofile.php?id=<?=$users[$i]['id']?>" class="button">See Profile</a>
        </div>
      </li>
    <?php } ?>
  </ul>
</section>

<?php
  require_once(__DIR__ . '/../templates/footer.tpl.php');
  drawFooter();
?>
