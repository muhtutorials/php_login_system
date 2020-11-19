<?php
    require 'header.php';
?>

<main>
    <?php
        $selector = $_GET['selector'];
        $validator = $_GET['validator'];

        if (empty($selector) || empty($validator)) {
            echo 'Could not validate your request!';
        } else {
            if (ctype_xdigit($selector) && ctype_xdigit($validator)) {
                ?>
                <form action="includes/reset-password.inc.php" method="post">
                    <input type="hidden" name="selector" value="<?= $selector ?>">
                    <input type="hidden" name="validator" value="<?= $validator ?>">
                    <input type="password" name="password" placeholder="Enter a new password">
                    <input type="password" name="password2" placeholder="Confirm your new password">
                    <button type="submit" name="reset-submit">Reset</button>
                </form>
                <?php
            }
        }
    ?>

</main>

<?php
    require 'footer.php';
?>
