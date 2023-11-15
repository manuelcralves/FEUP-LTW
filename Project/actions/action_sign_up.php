<?php
include_once('../utils/init.php');
include_once('../database/user.class.php');

	if(duplicateUsername($_POST['username'])){
		$_SESSION['ERROR'] = 'Duplicated Username';
		header("Location:".$_SERVER['HTTP_REFERER']."");
	}
	else if(duplicateEmail($_POST['email'])){
		$_SESSION['ERROR'] = 'Duplicated Email';
		header("Location:".$_SERVER['HTTP_REFERER']."");
	}
 	else if (($id = createUser($_POST['username'], $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['password'])) != -1) {

  		echo 'User Registered successfully';
 		setCurrentUser($id, $_POST['username']);
 		header("Location:../index.php");	
 	}
 	else{

  		$_SESSION['ERROR'] = 'ERROR';
  		header("Location:".$_SERVER['HTTP_REFERER']."");
 	}
 ?>