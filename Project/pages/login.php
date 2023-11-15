<?php
  declare(strict_types = 1);
  require_once(__DIR__ . '/../templates/headernouser.tpl.php');
  require_once(__DIR__ . '/../templates/footer.tpl.php');

  drawHeader();
?>
  <section id = "login">
  <h2>Login</h2>
  <form action="../actions/action_login.php" method="post" class="register_form">
                <input name="username" class="w3-input w3-border" type="text" placeholder="username" required="required">
                <input name="password" class="w3-input w3-border" type="password" placeholder="password" required="required">
                <input type="submit" name="Submit" value="Login">
            </form>
            <p id="error_messages" style="color: black">
                <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
            </p>
    <p>Don't have an account? <a href="/pages/signup.php">SignUp here</a>.</p>
  </section>
<?php
  drawFooter();
?>