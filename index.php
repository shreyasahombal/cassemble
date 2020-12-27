<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="output.css" type="text/css" rel="stylesheet" />
    <title>cassemble</title>
</head>

<body>
    <h1>CASSEMBLE</h1>
    <?php
    if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) {
    ?>
        <h1>Signed In</h1>
        <form action="backend/signout.bkd.php" method="POST">
            <button type="submit" name="submit-signout">Sign Out</button>
        </form>
    <?php
    } else {
    ?>
        <h5>Not Signed In</h5>
        <h3>Get Started As:</h3>
        <button><a href="auth/signUpStudent.php">Student</a></button>
        <button><a href="auth/signUpCollege.php">College</a></button>
        <button><a href="auth/signUpCompany.php">Company</a></button>
        <br><br><br>
        <h3>Sign In As:</h3>
        <button><a href="auth/signInStudent.php">Student</a></button>
        <button><a href="auth/signInCollege.php">College</a></button>
        <button><a href="auth/signInCompany.php">Company</a></button>
    <?php
    }

    ?>

</body>

</html>