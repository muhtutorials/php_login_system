<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Website</title>
</head>
<body>
    <nav>
        <div class="header-main">
            <a href="#">
                <img src="img/logo.png" alt="logo">
            </a>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="">Portfolio</a></li>
                <li><a href="">About Me</a></li>
                <li><a href="">Contacts</a></li>
            </ul>
        </div>
        <div class="header-login">
            <?php
                if (isset($_SESSION['id'])) {
                    echo
                        '<form action="includes/logout.inc.php" method="post">
                            <button type="submit" name="logout-submit">Logout</button>
                        </form>';
                } else {
                    echo
                        '<form action="includes/login.inc.php" method="post">
                            <input type="text" name="username_email" placeholder="Username or E-mail">
                            <input type="password" name="password" placeholder="Password">
                            <button type="submit" name="login-submit">Login</button>
                        </form>
                        <a href="signup.php">Signup</a>';
                }
            ?>
        </div>
    </nav>