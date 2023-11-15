<?php
    require_once(__DIR__ . '/../utils/init.php');

    if(!isset($_SESSION['username'])){
      header("Location:/index.php");
    }
    require_once(__DIR__ . '/../templates/header.tpl.php');
    require_once(__DIR__ . '/../templates/footer.tpl.php');
    include_once("../database/user.class.php");

    $_SESSION['userinfo'] = getUser($_SESSION['username']);
    drawHeader();
?>

<h1>Personal Information</h1>
<section id = "edit_profile">
    <div class="content">
        <div id="account">
            <div id="fields">
                <form action="../actions/action_update_user.php" method="post" class="register_form">
                    <label>First Name</label>
                    <input name="firstName" class="w3-input w3-border" type="text" placeholder="First Name" value="<?php echo htmlentities($_SESSION['userinfo']['firstName']) ?>" required="required">
                    <label>Last Name</label>
                    <input name="lastName" class="w3-input w3-border" type="text" placeholder="Last Name" value="<?php echo htmlentities($_SESSION['userinfo']['lastName']) ?>" required="required">
                    <label>Username</label>
                    <input name="username" class="w3-input w3-border" type="text" placeholder="Username" value="<?php echo htmlentities($_SESSION['userinfo']['username']) ?>" required="required">
                    <label>Email</label>
                    <input name="email" class="w3-input w3-border" type="email" placeholder="Email" value="<?php echo htmlentities($_SESSION['userinfo']['email']) ?>" required="required">
                    <label>Password</label>
                    <input name="currpassword" class="w3-input w3-border" type="password" placeholder="Password" required="required">
                    <span class="hint">One uppercase, 1 symbol, 1 number, at least 6 characters</span>
                    <h5> Optional </h5>
                    <input name="password" class="w3-input w3-border" type="password" placeholder="New Password">
                    <span class="hint">One uppercase, 1 symbol, 1 number, at least 6 characters</span>
                    <input name="passwordagain" class="w3-input w3-border" type="password" placeholder="Repeat New Password">
                    <span class="hint">Must match new password</span>
                    <input type="submit" name="profileupdate" value="Update Profile">
                </form>
            </div>
        </div>
    </div>
</section>

<?php
    drawFooter();
?>