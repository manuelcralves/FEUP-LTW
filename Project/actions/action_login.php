<?php
include_once("../utils/init.php");
include_once("../database/user.class.php");

if(($id = isLoginCorrect($_POST['username'], $_POST['password'])) != -1){

	setCurrentUser($id, $_POST['username']);
	header("Location:../pages/ticketpage.php");

} else {
	$_SESSION['ERROR'] = 'Incorrect username or password';
	header("Location:".$_SERVER['HTTP_REFERER']."");
}

?>