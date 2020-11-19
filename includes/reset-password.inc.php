<?php

if (isset($_POST['reset-submit'])) {
    $selector = $_POST['selector'];
    $validator = $_POST['validator'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    // probably better to check this earlier
    if (empty($password) || empty($password2)) {
        header("Location: ../create-new-password.php?newpassword=empty&selector=$selector&validator=$validator");
    } elseif ($password !== $password2) {
        header("Location: ../create-new-password.php?newpassword=passwordsnotmatch");
    }

    $currentDate = date("U");

    require "dbh.inc.php";

    $sql = "SELECT FROM reset_password WHERE selector=? AND expires >= $currentDate";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL error";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 'ss', $selector, $currentDate);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (!$row = mysqli_fetch_assoc($result)) {
            echo 'You need to re-submit your reset request.';
            exit();
        } else {
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row['token']);

            if (!$tokenCheck) {
                echo 'You need to re-submit your reset request.';
                exit();
            } else {
                $email = $row['email'];
                $sql = "SELECT * FROM users WHERE email = $email";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "SQL error";
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, 's', $email);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if (!$row = mysqli_fetch_assoc($result)) {
                        echo "SQL error";
                        exit();
                    } else {
                        $sql = "UPDATE users SET password=? WHERE email=?";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo "SQL error";
                            exit();
                        } else {
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, 'ss', $hashed_password, $email);
                            mysqli_stmt_execute($stmt);
                            $sql = 'DELETE FROM reset_password WHERE email=?';
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                echo 'SQL error';
                                exit();
                            } else {
                                mysqli_stmt_bind_param($stmt, 's', $email);
                                mysqli_stmt_execute($stmt);
                                header("Location: ../signup.php?newpassword=updated");
                            }
                        }
                    }
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header('Location: ../reset-password.php?reset=success');
} else {
    header('Location: ../index.php');
}