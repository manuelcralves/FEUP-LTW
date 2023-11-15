<?php

  require_once(__DIR__ . '/../utils/init.php');

  if(!isset($_SESSION['username'])){
    header("Location:/index.php");
  }

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../database/department.class.php');

  require_once(__DIR__ . '/../templates/header.tpl.php');
  require_once(__DIR__ . '/../templates/footer.tpl.php');
  require_once(__DIR__ . '/../templates/department.tpl.php');
  require_once(__DIR__ . '/../database/user.class.php');

  $isADMIN = isAdmin(getUserID());
 

  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $perPage = 7;
  $startId = ($page - 1) * $perPage + 1;
  $endId = $startId + $perPage - 1;

  $departments = Department::getDepartmentsWithinRange($dbh, $startId, $endId);

  drawHeader();
  drawDepartments($departments, $isADMIN);
  Department::drawPagination($page, $perPage, $dbh);
  drawFooter();
?>
