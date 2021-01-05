<?php
session_start();
if (isset($_POST['submit-job'])) {
    require 'db.php';

    $companyID = (int)$_POST['companyID'];
    $title = $_POST['title'];
    $jobDescription = $_POST['jobDescription'];

    $sql = "INSERT INTO job (companyID, title, content) VALUES (?,?,?) ;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "iss", $companyID, $title, $jobDescription);
        $addJob = mysqli_stmt_execute($stmt);
        if ($addJob) {
            header('Location: ../jobs.php?addJob=success');
            exit();
        } else {
            $error = mysqli_error($conn);
            header('Location: ../jobs.php?addJob=' . $error);
            exit();
        }
    }
} else {
    header('Location: ../index.php');
    exit();
}
