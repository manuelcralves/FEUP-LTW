<?php
    require_once(__DIR__ . '/../utils/init.php');

    if(!isset($_SESSION['username'])){
      header("Location:/index.php");
    }
    require_once(__DIR__ . '/../templates/header.tpl.php');
    require_once(__DIR__ . '/../templates/footer.tpl.php');
    include_once("../database/user.class.php");
    include_once("../database/department.class.php");

    $_SESSION['userinfo'] = getUser($_SESSION['username']);
    $isADMIN = isAdmin(getUserID());
    $isAGENT = isAgent(getUserID());
    $depart = Department::getName($_SESSION['userinfo']['id_department']);
    drawHeader();
?>

<div class="content">
    <h1>Profile of <?php echo htmlentities($_SESSION['userinfo']['username']) ?> <a href="/pages/edit_profile.php" class="buttonprof">Edit Profile</a></h1>

    <label>- First Name:</label>
    <h3><?php echo htmlentities($_SESSION['userinfo']['firstName']) ?></h3>
    <label>- Last Name:</label>
    <h3><?php echo htmlentities($_SESSION['userinfo']['lastName']) ?></h3>
    <label>- Username:</label>
    <h3><?php echo htmlentities($_SESSION['userinfo']['username']) ?></h3>
    <label>- Email:</label>
    <h3><?php echo htmlentities($_SESSION['userinfo']['email']) ?></h3>
    <?php
    if($isAGENT==true){
    ?>
    <label>- Department:</label>
    <h3><?php echo htmlentities($depart) ?></h3>
    <?php } ?>
    <label>- Agent:</label>
    <h3>
    <?php 
    if($_SESSION['userinfo']['is_agent']==true){
        echo htmlentities("This user is an agent");
    }else{
        echo htmlentities("This user is not an agent");
    }
    ?></h3>
    <label>- Admin:</label>
    <h3><?php if($_SESSION['userinfo']['is_admin']==true){
        echo htmlentities("This user is an admin");
    }else{
        echo htmlentities("This user is not an admin");
    }
    ?></h3>
</div>
<?php
    drawFooter();
?>