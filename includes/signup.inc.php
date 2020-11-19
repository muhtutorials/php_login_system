<?php

if (isset($_POST['signup-submit'])) {
    require 'dbh.inc.php';

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password= $_POST['password'];
    $password2= $_POST['password2'];

    if (empty($username) || empty($email) || empty($password) || empty($password2)) {
        header("Location: ../signup.php?error=emptyfields&username=$username&email=$email");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match('/^[a-zA-Z0-9]*$/', $username)) {
        header("Location: ../signup.php?error=invalidusernameoremail");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invalidemail&username=$username");
        exit();
    } elseif (!preg_match('/^[a-zA-Z0-9]*$/', $username)) {
        header("Location: ../signup.php?error=invalidusername&email=$email");
        exit();
    } elseif ($password !== $password2) {
        header("Location: ../signup.php?error=passwordcheck&username=$username&email=$email");
        exit();
    } else {
        $sql = "SELECT username FROM users WHERE username=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            // save result to stmt variable
            mysqli_stmt_store_result($stmt);
            $result_check = mysqli_stmt_num_rows($stmt);
            if ($result_check > 0) {
                header("Location: ../signup.php?error=usertaken&email=$email");
                exit();
            } else {
                $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../signup.php?error=sqlerror");
                    exit();
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../signup.php?signup=success");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header("Location: ../signup.php");
    exit();
}
