<?php

if (isset($_POST['reset-submit'])) {
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "http://localhost:8080/php_login_system/create-new-password.php?selector=$selector&validator=" . bin2hex($token);
    $expires = date("U") + 1800;

    require 'dbh.inc.php';
    $email = $_POST['email'];
    $sql = 'DELETE FROM reset_password WHERE email=?';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'SQL error';
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
    }
    $sql = "INSERT INTO reset_password (email, selector, token, expires) VALUES (?, ?, ?, ?)";
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'SQL error';
        exit();
    } else {
        $hashed_token = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, 'ssss', $email, $selector, $hashed_token, $expires);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    $to = $email;
    $subject = 'Reset your password for localhost';
    $message = '<p>We received a request for a password reset for localhost website. Visit the link to change the password.
                If you didn\'t request anything ignore this e-mail</p>';
    $message .= '<p>Here\'s your password reset link:</p>';
    $message .= "<a href='$url'>$url</a>";
    $headers = 'From: admin <localhost>\r\n';
    $headers .= 'Reply-to: localhost\r\n';
    $headers .= 'Content-type: text/html\r\n';

    mail($to, $subject, $message, $headers);
    header('Location: ../reset-password.php?reset=success');
} else {
    header('Location: ../index.php');
}