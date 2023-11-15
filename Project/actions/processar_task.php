<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/init.php');

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/task.class.php');


  $task_id = Task::create($dbh, $_POST['title'], $_POST['description'], intval(getUserID()));

  if ($task_id) {
    header("Location: ../pages/tasks.php?id=$task_id");
  } else {
    header('Location: ../tasks.php');
  }

?>