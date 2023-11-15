<?php
    include_once('../utils/init.php');
    if(getUserID() !== null  && getUsername() !== null) {
        unset($_SESSION['username']);
        unset($_SESSION['id']);
        header('Location:../pages/index.php');   

    } else {
        $_SESSION['ERROR'] = "Error logging out!";
        header("Location:".$_SERVER['HTTP_REFERER']."");
    }
?>