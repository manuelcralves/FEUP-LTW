<?php
include_once("../utils/init.php");
require_once(__DIR__ . '/../templates/headernouser.tpl.php');
require_once(__DIR__ . '/../templates/footer.tpl.php');

drawHeader();
?>
<section id = "register">
    <h2>SignUp</h2>
    <form action="../actions/action_sign_up.php" method="post" class="register_form">
                <input name="firstName" class="w3-input w3-border" type="text" placeholder="First Name" required="required">
                <input name="lastName" class="w3-input w3-border" type="text" placeholder="Last Name" required="required">
                <input name="username" class="w3-input w3-border" type="text" placeholder="Username" required="required">
                <span class="hint">Only lowercase and numbers, at least 6 characters.</span>
                <input name="email" class="w3-input w3-border" type="email" placeholder="Email" required="required">
                <input name="password" class="w3-input w3-border" type="password" placeholder="Password">
                <span class="hint">One uppercase, 1 symbol, 1 number, at least 6 characters.</span>
                <input name="passwordagain" class="w3-input w3-border" type="password" placeholder="Repeat Password">
                <span class="hint">Must match new password.</span>
                <input name="Submit" class="w3-input w3-border" type="submit" value="SignUp">
            </form>
            <p> <?php echo htmlentities($error) ?> </p>
    <p>Already have an account? <a href="/pages/login.php">Login here</a>.</p>
</section>

<?php
  drawFooter();
?>