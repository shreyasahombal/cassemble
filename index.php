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
    <?php
    } else {
    ?>
        <h5>Not Signed In</h5>
        <h3>Get Started As:</h3>
        <button><a href="authentication/signUpStudent.php">Student</a></button>
        <button>College</button>
        <button>Company</button>
    <?php
    }

    ?>

</body>

</html>