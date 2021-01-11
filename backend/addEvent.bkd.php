<?php
session_start();
if (isset($_POST['submit-event'])) {
    require 'db.php';

    $collegeID = (int)$_POST['collegeID'];
    $title = $_POST['title'];
    $eventDescription = $_POST['eventDescription'];

    $sql = "INSERT INTO events (collegeID, title, content) VALUES (?,?,?) ;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../events.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "iss", $collegeID, $title, $eventDescription);
        $addJob = mysqli_stmt_execute($stmt);
        if ($addJob) {
            header('Location: ../events.php?addEvent=success');
            exit();
        } else {
            $error = mysqli_error($conn);
            header('Location: ../events.php?addEvent=' . $error);
            exit();
        }
    }
} else {
    header('Location: ../index.php');
    exit();
}
