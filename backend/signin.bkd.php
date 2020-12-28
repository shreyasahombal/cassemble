<?php
if (isset($_POST['submit-signin-student'])) {
    require 'db.php';

    $emailID = $_POST['emailID'];
    $password = $_POST['password'];

    if (empty($emailID) || empty($password)) {
        header("Location: ../auth/signInStudent.php?error=emptyfields");
        exit();
    } else {
        $sql = "SELECT * FROM student WHERE emailID=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../auth/signInStudent.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $emailID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $passwordCheck = password_verify($password, $row['password']);
                if ($passwordCheck == false) {
                    header("Location: ../auth/signInStudent.php?error=incorrectpassword&emailID");
                    exit();
                } else if ($passwordCheck == true) {
                    session_start(); //put this on all pages...
                    $_SESSION['userType'] = 'student';
                    $_SESSION['userEmailID'] = $emailID;
                    $_SESSION['userID'] = $row['studentID'];


                    //check for createdProfile?
                    $createdProfileQuery = mysqli_query($conn, "SELECT name, streamID, collegeID, streamYear FROM student WHERE studentID = ".$row['studentID'].";");

                    while ($createdProfileArr = mysqli_fetch_array($createdProfileQuery)) {
                        echo 'Hello';
                        if ($createdProfileArr['name'] == NULL && $createdProfileArr['streamID'] == NULL && $createdProfileArr['collegeID'] == NULL && $createdProfileArr['streamYear'] == NULL) {
                            header("Location: ../profile/createStudentProfile.php?notify=completeprofile");
                            exit();
                        } else {
                            $_SESSION['signedIn'] = true;
                            header("Location: ../index.php?signin=success");
                            exit();
                        }
                    }


                } else {
                    header("Location: ../auth/signInStudent.php?error=sqlerror");
                    exit();
                }
            } else {
                header("Location: ../auth/signInStudent.php?error=nouser");
                exit();
            }
        }
    }
} else if (isset($_POST['submit-signin-college'])) {
    require 'db.php';

    $emailID = $_POST['emailID'];
    $password = $_POST['password'];

    if (empty($emailID) || empty($password)) {
        header("Location: ../auth/signInCollege.php?error=emptyfields");
        exit();
    } else {
        $sql = "SELECT * FROM college WHERE emailID=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../auth/signInCollege.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $emailID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $passwordCheck = password_verify($password, $row['password']);
                if ($passwordCheck == false) {
                    header("Location: ../auth/signInCollege.php?error=incorrectpassword&emailID");
                    exit();
                } else if ($passwordCheck == true) {
                    session_start(); //put this on all pages...
                    $_SESSION['userType'] = 'college';
                    $_SESSION['userEmailID'] = $emailID;
                    $_SESSION['userID'] = $row['collegeID'];


                    //check for createdProfile?
                    $createdProfileQuery = mysqli_query($conn, "SELECT name, cityID, stateID, websiteURL, logoURL, bannerURL FROM college WHERE collegeID = ".$row['collegeID'].";");

                    while ($createdProfileArr = mysqli_fetch_array($createdProfileQuery)) {
                        if ($createdProfileArr['name'] == NULL && $createdProfileArr['cityID'] == NULL && $createdProfileArr['stateID'] == NULL && $createdProfileArr['websiteURL'] == NULL && $createdProfileArr['logoURL'] == NULL && $createdProfileArr['bannerURL'] == NULL) {
                            header("Location: ../profile/createCollegeProfile.php?notify=completeprofile");
                            exit();
                        } else {
                            $_SESSION['signedIn'] = true;
                            header("Location: ../index.php?signin=success");
                            exit();
                        }
                    }
                } else {
                    header("Location: ../auth/signInCollege.php?error=sqlerror");
                    exit();
                }
            } else {
                header("Location: ../auth/signInCollege.php?error=nouser");
                exit();
            }
        }
    }
} else if (isset($_POST['submit-signin-company'])) {
    require 'db.php';

    $emailID = $_POST['emailID'];
    $password = $_POST['password'];

    if (empty($emailID) || empty($password)) {
        header("Location: ../auth/signInCompany.php?error=emptyfields");
        exit();
    } else {
        $sql = "SELECT * FROM company WHERE emailID=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../auth/signInCompany.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $emailID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $passwordCheck = password_verify($password, $row['password']);
                if ($passwordCheck == false) {
                    header("Location: ../auth/signInCompany.php?error=incorrectpassword&emailID");
                    exit();
                } else if ($passwordCheck == true) {
                    session_start(); //put this on all pages...
                    $_SESSION['userType'] = 'company';
                    $_SESSION['userEmailID'] = $emailID;
                    $_SESSION['userID'] = $row['companyID'];


                    //check for createdProfile?
                    $createdProfileQuery = mysqli_query($conn, "SELECT name, websiteURL, logoURL FROM company WHERE companyID = ".$row['companyID'].";");

                    while ($createdProfileArr = mysqli_fetch_array($createdProfileQuery)) {
                        if ($createdProfileArr['name'] == NULL && $createdProfileArr['websiteURL'] == NULL && $createdProfileArr['logoURL'] == NULL) {
                            header("Location: ../profile/createCompanyProfile.php?notify=completeprofile");
                            exit();
                        } else {
                            $_SESSION['signedIn'] = true;
                            header("Location: ../index.php?signin=success");
                            exit();
                        }
                    }
                } else {
                    header("Location: ../auth/signInCompany.php?error=sqlerror");
                    exit();
                }
            } else {
                header("Location: ../auth/signInCompany.php?error=nouser");
                exit();
            }
        }
    }
} else {
    header("Location: ../index.php");
    exit();
}
