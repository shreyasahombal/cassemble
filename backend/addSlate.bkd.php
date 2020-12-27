<?php
session_start();
if (isset($_POST['submit-slate'])) {
    require 'db.php';

    $studentID = $_POST['studentID'];
    $collegeID = $_POST['collegeID'];
    $companyID = $_POST['companyID'];
    $content = $_POST['content'];

    $sql = "INSERT slate (studentID, collegeID, companyID, content) VALUES (?,?,?,?) ;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ssss", $studentID, $collegeID, $companyID, $content);
        mysqli_stmt_execute($stmt);
        header('Location: ../index.php?addSlate=success');
        exit();
    }
} else {
    header('Location: ../index.php');
    exit();
}
