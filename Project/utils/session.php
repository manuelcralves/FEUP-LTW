<?php
   session_start();

   function setCurrentUser($userID, $username) {
    	$_SESSION['username'] = $username;
    	$_SESSION['userID'] = $userID;
   }

   function getUserID() {
       if(isset($_SESSION['userID'])) {
            return $_SESSION['userID'];
       } else {
           return null;
       }

   }

   function getUsername() {
        if(isset($_SESSION['username'])) {
            return $_SESSION['username'];
        } else {
            return null;
        }
    }
?>