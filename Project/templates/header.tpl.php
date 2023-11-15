<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../utils/init.php'); 
?>

<?php function drawHeader() { ?>
    <!DOCTYPE html>
<html lang="en-US">
    <?php 
    require_once(__DIR__ . '/../database/user.class.php');
    $_SESSION['userinfo'] = getUser($_SESSION['username']);
    ?>
    <head>
        <title>HelpDesk - Trouble Tickets</title>
        <link rel="stylesheet" href="../css/style.css"> 
        <script src="../javascript/script.js" defer></script>
    </head>
    <body>
        <header>
            <h1><a href = "/pages/ticketpage.php">HelpDesk</a></h1>
            <section class="logout-edit">
                <a href="/pages/profile.php"><button id="logout">Profile</button></a>
                <a href="../actions/action_logout.php"><button id="logout">Logout</button></a>
            </section>
            <nav>
            <ul>
                <li><a href="/pages/ticketpage.php">My Tickets</a></li>
                <li><a href="/pages/department.php">Departments</a></li>
                <li><a href="/pages/faq.php">FAQ</a></li>
                <li><a href="/pages/aboutus.php">About us</a></li>
                <?php
                if($_SESSION['userinfo']['is_admin']==true){
                ?>
                <li><a href="/pages/users.php">Users</a></li>
                <?php } ?> 
                <?php
                if($_SESSION['userinfo']['is_admin']==true || $_SESSION['userinfo']['is_agent']==true){
                ?>
                <li><a href="/pages/tasks.php">My Tasks</a></li>
                <li><a href="/pages/departmentTicket.php?id=<?php echo intval($_SESSION['userinfo']['id_department']); ?>">My Department</a></li>           
                <li><a href="/pages/ticketAvailable.php">Tickets Available</a></li>
                <li><a href="/pages/ticketsToHandle.php">My Tickets to handle</a></li>
                <?php } ?> 
            </ul>
            </nav>
        </header>
        <main>
<?php } ?>