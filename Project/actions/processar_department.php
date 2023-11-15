<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/init.php');

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/department.class.php');


  $department_id = Department::create($dbh, $_POST['name']);


  header('Location: ../pages/department.php');

?>