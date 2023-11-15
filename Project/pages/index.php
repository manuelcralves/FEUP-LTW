<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../templates/headernouser.tpl.php');
require_once(__DIR__ . '/../templates/footer.tpl.php');

drawHeader();
?>
  <section class="homepage">
    <img src="../images/logo.jpg" alt="HelpDesk">
    <h2>Let us help you take the trouble out of your tickets.</h2>
    <p>Welcome to our trouble tickets website, where you can submit, manage, and track your support requests with ease. Our platform is designed to simplify the ticket management process and provide you with a seamless experience when interacting with our support team. Whether you need help with a technical issue, have a question, or want to report a bug, our team is here to assist you.</p>
  </section>
  <section class="loginregister">
    <a href="/pages/login.php" class="button">Login</a><a href="/pages/signup.php" class="button register-btn">SignUp</a>
  </section>
  
<?php
  drawFooter();
?>
