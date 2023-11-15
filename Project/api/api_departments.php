<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/init.php');

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/department.class.php');


  $departments = Department::searchDepartments($dbh, $_GET['search'], 14);

  echo json_encode($departments);
?>