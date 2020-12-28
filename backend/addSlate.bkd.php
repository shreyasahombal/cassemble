<?php
session_start();
if (isset($_POST['submit-slate'])) {
    require 'db.php';

    $studentID = (int)$_POST['studentID'];
    $collegeID = (int)$_POST['collegeID'];
    $companyID = (int)$_POST['companyID'];
    $content = $_POST['content'];

    if($studentID != 0) {
        echo 'Hi';
        $sql = "INSERT INTO slate (studentID, content) VALUES (?,?) ;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "is", $studentID, $content);
            $addSlate = mysqli_stmt_execute($stmt);
            if($addSlate) {
                header('Location: ../index.php?addSlate=success');
                exit();
            } else {
                $error = mysqli_error($conn);
                header('Location: ../index.php?addSlate='.$error);
                exit();
            }
        }
    } 
    if($collegeID != 0) {
        $sql = "INSERT INTO slate (collegeID, content) VALUES (?,?) ;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "is", $collegeID, $content);
            mysqli_stmt_execute($stmt);
            if(mysqli_stmt_execute($stmt)) {
                header('Location: ../index.php?addSlate=success');
                exit();
            } else {
                $error = mysqli_error($conn);
                header('Location: ../index.php?addSlate='.$error);
                exit();
            }
        }
    } 
    if($companyID != 0) {
        $sql = "INSERT INTO slate (companyID, content) VALUES (?,?) ;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "is",$companyID, $content);
            mysqli_stmt_execute($stmt);
            if(mysqli_stmt_execute($stmt)) {
                header('Location: ../index.php?addSlate=success');
                exit();
            } else {
                $error = mysqli_error($conn);
                header('Location: ../index.php?addSlate='.$error);
                exit();
            }
        }
    }
} else {
    header('Location: ../index.php');
    exit();
}
