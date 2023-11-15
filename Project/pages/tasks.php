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
      <h2>My Tasks 
        <a href="nova_task.php" class="button">Create new Task</a>
      </h2> 

      <ul>
        <?php  
        require_once(__DIR__ . '/../actions/getUser_tasks.php');
        if(count($tasks) == 0){
          echo "<h3>No tasks from this user</h3>";
        }

        for($i = 0; $i < count($tasks); $i++) { 
            if($tasks[$i]['is_completed'] == true){
                $comp = "-- Task done --";
            }else{
                $comp = "-- Task to do --";
            }
        ?>
        <li>
          <div class="ticket" id="<?=$tasks[$i]['id']?>">
            <h3> <?=$tasks[$i]['title']?></h3>
            <p> <?=$tasks[$i]['description']?> </p>
            <p> <?=$comp?> </p>
            <?php
            if ($tasks[$i]['is_completed'] == false) {
                echo '<button onclick="closeTask()">Close this Task</button>';
            }
            ?>
          </div>
        </li>
        <?php } ?>   
      </ul>
    </section>

    <script>
      function closeTask() {
          var xhr = new XMLHttpRequest();
          xhr.open('POST', '../actions/action_close_task.php', true);
          xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
          xhr.onreadystatechange = function() {
              if (xhr.readyState === 4 && xhr.status === 200) {
                  var response = xhr.responseText;
                  if (response === 'success') {
                      // Reload the page without changing the URL
                      window.location.reload(false);
                  } else {
                      alert('Failed to update task status.');
                  }
              }
          };
          xhr.send('taskId=<?php echo $_GET['id']; ?>');
      }
    </script>
  
<?php
  drawFooter();
?>