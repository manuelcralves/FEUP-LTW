<?php
  include_once('utils/init.php');
  
  if(!isset($_SESSION['username'])){
    header("Location:pages/index.php");
  } else {
  	header("Location:pages/ticketpage.php");
  }
?>