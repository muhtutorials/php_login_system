<?php
    require 'header.php';
?>

<main>
    <h1>Signup</h1>
    <br>
    <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyfields") {
                echo "<p class='error-text'>Fill in all fields</p><br>";
            } elseif ($_GET['error'] == "invaliduid") {
                echo "<p class='error-text'>Invalid username</p><br>";
            }
            // and so on
        } elseif (isset($_GET['signup']) && $_GET['signup'] == "success") {
            echo "<p class='success'>Signup successful</p><br>";
        }

        if (isset($_GET['newpassword'])) {
            if ($_GET['newpassword'] == "updated") {
                echo "<p class='success'>Password change successful</p><br>";
            }
        }
    ?>
    <form action="includes/signup.inc.php" method="post">
        <input type="text" name="username" placeholder="Username"><br><br>
        <input type="text" name="email" placeholder="E-mail"><br><br>
        <input type="password" name="password" placeholder="Password"><br><br>
        <input type="password" name="password2" placeholder="Confirm password"><br><br>
        <button type="submit" name="signup-submit">Signup</button>
    </form>
    <a href="reset-password.php">Forgot Your Password?</a>
</main>

<?php
    require 'footer.php';
?>
