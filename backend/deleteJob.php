<?php
require 'db.php';

session_start();
$studentID = $collegeID = $companyID = $id = 0;
$userType;
if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) {
    if ($_SESSION['userType'] === 'student') {
        $studentID = $_SESSION['userID'];
        $userType = 'student';
    } else if ($_SESSION['userType'] === 'college') {
        $collegeID = $_SESSION['userID'];
        $userType = 'college';
    } else if ($_SESSION['userType'] === 'company') {
        $companyID = $_SESSION['userID'];
        $userType = 'company';
    }
    $userID = $_SESSION['userID'];
}

if(isset($_GET['jobID'])) {
    $jobID = $_GET['jobID'];
    $idString = 'ID';
    $idColumn = $userType . $idString;

    $result = mysqli_query($conn, "DELETE FROM job WHERE jobID = $jobID AND $idColumn = $userID ;");
    if (!$result) {
        header('Location: ../jobs.php?deleteJob=error');
        exit();
    } else {
        header('Location: ../jobs.php?deleteJob=success');
        exit();
    }
}