<?php
    require 'header.php';
?>

<main>
    <h1>Reset your password</h1>
    <p>An E-mail will be sent to you with instructions on how to reset your password.</p>
    <br>
    <form action="includes/reset-request.inc.php" method="post">
        <input type="text" name="email" placeholder="Enter Your E-mail Address"><br><br>
        <button type="submit" name="reset-submit">Submit</button>
    </form>
    <?php
        if (isset($_GET['reset'])) {
            if (isset($_GET['reset']) == 'success') {
                echo '<p class="success">Check your E-mail</p>';
            }
        }
    ?>
</main>

<?php
    require 'footer.php';
?>

