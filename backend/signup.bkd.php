<?php
if (isset($_POST['submit-signup-student'])) {
    require 'db.php';

    $emailID = $_POST['emailID'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpassword'];

    if (empty($emailID) || empty($password) || empty($confirmPassword)) {
        header("Location: ../auth/signUpStudent.php?error=emptyfields");
        exit();
    }
    else if ($password !== $confirmPassword) {
        header("Location: ../auth/signUpStudent.php?error=invalidconfirmpassword");
        exit();
    } else {
        $sql = "SELECT emailID FROM college WHERE emailID=?";
        $stmt = mysqli_stmt_init($conn); //initialized the connection
        if (!mysqli_stmt_prepare($stmt, $sql)) { //checking if connection is perfect
            header("Location: ../auth/signUpStudent.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $emailID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt); //if there is someone who has the same emailID
            if ($resultCheck > 0) {
                header("Location: ../auth/signUpStudent.php?error=emailIDtaken");
                exit();
            } else { //everything is perfect... USER new
                $sql = "INSERT INTO student (emailID, password) VALUES (?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../auth/signUpStudent.php?error=sqlerror");
                    exit();
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "ss", $emailID, $hashedPassword);
                    mysqli_stmt_execute($stmt);
                    session_start();
                    $_SESSION['userType'] = 'student';
                    $_SESSION['userEmailID'] = $emailID;
                    header("Location: ../profile/createStudentProfile.php?registration=success");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else if (isset($_POST['submit-signup-college'])) {
    require 'db.php';

    $emailID = $_POST['emailID'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpassword'];

    if (empty($emailID) || empty($password) || empty($confirmPassword)) {
        header("Location: ../auth/signUpCollege.php?error=emptyfields");
        exit();
    }
    else if ($password !== $confirmPassword) {
        header("Location: ../auth/signUpCollege.php?error=invalidconfirmpassword");
        exit();
    } else {
        $sql = "SELECT emailID FROM college WHERE emailID=?";
        $stmt = mysqli_stmt_init($conn); //initialized the connection
        if (!mysqli_stmt_prepare($stmt, $sql)) { //checking if connection is perfect
            header("Location: ../auth/signUpCollege.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $emailID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt); //if there is someone who has the same emailID
            if ($resultCheck > 0) {
                header("Location: ../auth/signUpCollege.php?error=emailIDtaken");
                exit();
            } else { //everything is perfect... USER new
                $sql = "INSERT INTO college (emailID, password) VALUES (?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../auth/signUpCollege.php?error=sqlerror");
                    exit();
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "ss", $emailID, $hashedPassword);
                    mysqli_stmt_execute($stmt);
                    session_start();
                    $_SESSION['userType'] = 'college';
                    $_SESSION['userEmailID'] = $emailID;
                    header("Location: ../profile/createCollegeProfile.php?registration=success");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} if (isset($_POST['submit-signup-company'])) {
    require 'db.php';

    $emailID = $_POST['emailID'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpassword'];

    if (empty($emailID) || empty($password) || empty($confirmPassword)) {
        header("Location: ../auth/signUpCompany.php?error=emptyfields&emailID=" . $emailID);
        exit();
    } else if ($password !== $confirmPassword) {
        header("Location: ../auth/signUpCompany.php?error=invalidconfirmpassword&emailID=" . $emailID);
        exit();
    } else {
        $sql = "SELECT emailID FROM company WHERE emailID=?";
        $stmt = mysqli_stmt_init($conn); //initialized the connection
        if (!mysqli_stmt_prepare($stmt, $sql)) { //checking if connection is perfect
            header("Location: ../auth/signUpCompany.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $emailID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt); //if there is someone who has the same emailID
            if ($resultCheck > 0) {
                header("Location: ../auth/signUpCompany.php?error=emailIDtaken");
                exit();
            } else { //everything is perfect... USER new
                $sql = "INSERT INTO company (emailID, password) VALUES (?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../auth/signUpCompany.php?error=sqlerror");
                    exit();
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "ss", $emailID, $hashedPassword);
                    mysqli_stmt_execute($stmt);

                    session_start();
                    $_SESSION['userType'] = 'company';
                    $_SESSION['userEmailID'] = $emailID;
                    header("Location: ../profile/createCompanyProfile.php?registration=success");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

else {
    header("Location: ../signup.php");
    exit();
}
