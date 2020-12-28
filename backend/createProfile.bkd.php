<?php
session_start();


if (isset($_POST['submit-create-student-profile'])) {
    require 'db.php';

    $studentID = $_POST['studentID'];
    $name = $_POST['name'];
    $collegeID = $_POST['collegeID'];
    $streamID = $_POST['streamID'];
    $streamYear = $_POST['streamYear'];
    $skillsArray = $_POST['skills'];
    $websiteURL = $_POST['websiteURL'];
    $imageURL = $_POST['imageURL'];
    $resumeURL = $_POST['resumeURL'];

    foreach ((array)$skillsArray as $skillID) {
        $intSkillID = (int)$skillID;
        $sql = "INSERT INTO studentandskill (studentID, skillID) VALUES (?, ?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../profile/createStudentProfile.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ii", $studentID, $intSkillID);
            mysqli_stmt_execute($stmt);
        }
    }


    $stmt = "UPDATE student SET name = '$name', collegeID = '$collegeID', streamID = '$streamID', websiteURL = '$websiteURL', imageURL = '$imageURL', resumeURL = '$resumeURL', streamYear = '$streamYear' WHERE studentID = '$studentID';";
    $updated = mysqli_query($conn, $stmt);
    if ($updated) {
        session_unset();
        session_destroy();
        header("Location: ../auth/signInStudent.php?signup=success");
        exit();
    } else {
        echo $conn->error;
        // header("Location: ../profile/createStudentProfile.php?error=sqlerror.$studentID.");
        // exit();
    }
} else if (isset($_POST['submit-create-college-profile'])) {
    require 'db.php';

    $collegeID = $_POST['collegeID'];
    $name = $_POST['name'];
    $stateID = $_POST['state'];
    $cityID = $_POST['city'];
    $streamsArray = $_POST['streams'];
    $websiteURL = $_POST['websiteURL'];
    $logoURL = $_POST['logoURL'];
    $bannerURL = $_POST['bannerURL'];

    $insertedStreams = true;

    foreach ((array)$streamsArray as $streamID) {
        $intStreamID = (int)$streamID;
        $sql = "INSERT INTO collegeandstream (collegeID, streamID) VALUES ($collegeID, $streamID);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../profile/createCollegeProfile.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ii", $collegeID, $intStreamID);
            mysqli_stmt_execute($stmt);
        }
    }

    $stmt = "UPDATE college SET name = '$name', stateID = '$stateID', cityID = '$cityID', websiteURL = '$websiteURL', logoURL = '$logoURL', bannerURL = '$bannerURL' WHERE collegeID = '$collegeID' ;";
    $updated = mysqli_query($conn, $stmt);
    if ($updated) {
        session_unset();
        session_destroy();
        header("Location: ../auth/signInCollege.php?signup=success");
        exit();
    } else {
        header("Location: ../profile/createCollegeProfile.php?error=sqlerror.$collegeID.selectoptionsnotselected");
        exit();
    }
} else if (isset($_POST['submit-create-company-profile'])) {
    require 'db.php';

    $companyID = $_POST['companyID'];
    $name = $_POST['name'];
    $headquarters = $_POST['headquarters'];
    $description = $_POST['description'];
    $websiteURL = $_POST['websiteURL'];
    $logoURL = $_POST['logoURL'];

    $stmt = "UPDATE company SET name = '$name', headquarters = '$headquarters', description = '$description', websiteURL = '$websiteURL', logoURL = '$logoURL' WHERE companyID = '$companyID' ;";
    $updated = mysqli_query($conn, $stmt);
    if ($updated) {
        session_unset();
        session_destroy();
        header("Location: ../auth/signInCompany.php?signup=success");
        exit();
    } else {
        $error = mysqli_error($conn);
        echo $error;
    }
} else {
    header("Location: ../index.php");
    exit();
}
