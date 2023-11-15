<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/init.php');

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/faq.class.php');


  $faq_id = Faq::create($dbh, $_POST['title'], $_POST['description']);

  if ($faq_id) {
    header("Location: ../pages/faq.php?id=$faq_id");
  } else {
    header('Location: ../faq.php');
  }

?>