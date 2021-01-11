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


if (isset($_POST['bookmark'])) {
    $slateID = $_POST['slateID'];
    $idString = 'ID';
    $idColumn = $userType . $idString;

    $result = mysqli_query($conn, "INSERT INTO bookmarks ($idColumn, slateID) VALUES ($userID, $slateID)");

    mysqli_query($conn, "UPDATE slate SET numOfBookmarks = numOfBookmarks+1 WHERE slateID = $slateID ;");
    if (!$result) {
        echo mysqli_error($conn);
    }

    echo 'hi';
} else if (isset($_POST['bookmarkJob'])) {
    $jobID = $_POST['jobID'];
    $idString = 'ID';
    $idColumn = $userType . $idString;

    $result = mysqli_query($conn, "INSERT INTO bookmarks ($idColumn, jobID) VALUES ($userID, $jobID)");
    if (!$result) {
        echo mysqli_error($conn);
    }

    echo 'hi';
} else if (isset($_POST['bookmarkEvent'])) {
    $eventID = $_POST['eventID'];
    $idString = 'ID';
    $idColumn = $userType . $idString;

    $result = mysqli_query($conn, "INSERT INTO bookmarks ($idColumn, eventID) VALUES ($userID, $eventID)");
    if (!$result) {
        echo mysqli_error($conn);
    }

    echo 'hi';
} else if (isset($_POST['unbookmarkJob'])) {
    $jobID = $_POST['jobID'];
    $idString = 'ID';
    $idColumn = $userType . $idString;

    $result = mysqli_query($conn, "DELETE FROM bookmarks WHERE jobID = $jobID AND $idColumn = $userID ;");
    if (!$result) {
        echo mysqli_error($conn);
    }
    echo 'bye';
} else if (isset($_POST['unbookmarkEvent'])) {
    $eventID = $_POST['eventID'];
    $idString = 'ID';
    $idColumn = $userType . $idString;

    $result = mysqli_query($conn, "DELETE FROM bookmarks WHERE eventID = $eventID AND $idColumn = $userID ;");
    if (!$result) {
        echo mysqli_error($conn);
    }
    echo 'bye';
} else if (isset($_POST['unbookmark'])) {
    $slateID = $_POST['slateID'];
    $idString = 'ID';
    $idColumn = $userType . $idString;

    $result = mysqli_query($conn, "DELETE FROM bookmarks WHERE slateID = $slateID AND $idColumn = $userID ;");
    if (!$result) {
        echo mysqli_error($conn);
    }
    $result = mysqli_query($conn, "UPDATE slate SET numOfBookmarks = numOfBookmarks-1 WHERE slateID = $slateID");
    if (!$result) {
        echo mysqli_error($conn);
    }
    echo 'bye';
} else if (isset($_POST['applyForJob'])) {
    $jobID = $_POST['jobID'];

    $result = mysqli_query($conn, "INSERT INTO jobandstudent (studentID, jobID) VALUES ($userID, $jobID);");
    if (!$result) {
        echo mysqli_error($conn);
    }
    echo 'applyForJob';
} else if (isset($_POST['registerForEvent'])) {
    $eventID = $_POST['eventID'];

    $result = mysqli_query($conn, "INSERT INTO eventsandstudent (studentID, eventID) VALUES ($userID, $eventID);");
    if (!$result) {
        echo mysqli_error($conn);
    }
    echo 'registerForEvent';
} else if (isset($_POST['bookmarked'])) {
    $slateID = $_POST['slateID'];
    $idString = 'ID';
    $idColumn = $userType . $idString;

    $bookmarkedQuery = mysqli_query($conn, "SELECT * FROM bookmarks WHERE slateID = $slateID AND $idColumn = $userID ;");

    while ($bookmarkedArr = mysqli_fetch_array($bookmarkedQuery)) {
        echo 'yes';
        exit();
    }

    echo 'no';
} else if (isset($_POST['replyToSlate'])) {
    $slateID = $_POST['slateID'];
    $content = $_POST['content'];
    $idString = 'ID';
    $idColumn = $userType . $idString;

    $result = mysqli_query($conn, "INSERT INTO reply ($idColumn, slateID, content) VALUES ('".$userID."', '".$slateID."', '".$content."') ;");
    if (!$result) {
        echo mysqli_error($conn);
    }
} else if (isset($_POST['editSlate'])) {
    $slateID = $_POST['slateID'];
    $content = $_POST['content'];

    echo $content;
    $result = mysqli_query($conn, "UPDATE slate SET content = '".$content."' WHERE slateID = '".$slateID."' ;");
    if (!$result) {
        echo mysqli_error($conn);
    }
} else if (isset($_POST['editReply'])) {
    $replyID = $_POST['replyID'];
    $content = $_POST['content'];

    echo $content;
    $result = mysqli_query($conn, "UPDATE reply SET content = '".$content."' WHERE replyID = '".$replyID."' ;");
    if (!$result) {
        echo mysqli_error($conn);
    }
} else {
    header('Location: ../test.php');
    exit();
}
