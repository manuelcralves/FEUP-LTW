<?php
    include_once('../utils/init.php');
    include_once("../database/user.class.php");

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username= $_POST['username'];
    $email = $_POST['email'];
    $currpassword = $_POST['currpassword'];
    $newpassword = $_POST['password'];

    if((isLoginCorrect($_SESSION['userinfo']['username'], $_POST['currpassword'])) != -1){
        if($firstName !== null && $lastName !== null && $username !== null && $email!==null) {

            if(updateUserInfo (getUserID(), $firstName, $lastName, $username, $email)){
                setCurrentUser(getUserID(), $username);
                $_SESSION['userinfo'] = getUser($_SESSION['username']);

                if($newpassword != null){
                    if(!updateUserPassword(getUserID(), $newpassword))
                        $_SESSION['ERROR']= "Error: updating password";                    
                }

            } else $_SESSION['ERROR'] = "Error: updating data base";      

        } else $_SESSION['ERROR'] = "Error: name, username, email and password cannot be null";

    } else $_SESSION['ERROR'] = "Error: password is not correct";


    header("Location:".$_SERVER['HTTP_REFERER']."");
        
?>