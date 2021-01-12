<?php
require 'backend/db.php';
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="public/build/tailwind.css" type="text/css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>students</title>
</head>

<body>
    <!-- <div class="text-center font-black text-3xl">cassemble</div> -->
    <nav class="sticky bg-white px-6 py-4 shadow">
        <div class="flex flex-col container mx-auto md:flex-row md:items-center md:justify-between">
            <div class="flex justify-between items-center">
                <div>
                    <a href="#" class="text-gray-800 text-xl font-black md:text-2xl">cassemble</a>
                </div>
                <div>
                    <button type="button" class="block text-gray-800 hover:text-gray-600 focus:text-gray-600 focus:outline-none md:hidden">
                        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current">
                            <path d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="md:flex flex-col md:flex-row md:-mx-4 hidden">
                <a href="#" class="my-1 text-gray-800 hover:text-blue-500 md:mx-4 md:my-0">Jobs</a>
                <a href="#" class="my-1 text-gray-800 hover:text-blue-500 md:mx-4 md:my-0">Slates</a>
                <a href="#" class="my-1 text-gray-800 hover:text-blue-500 md:mx-4 md:my-0">Events</a>
                <?php
                if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) {
                ?>
                    <a href="profile/myProfile.php" class="my-1 text-gray-800 hover:text-blue-500 md:mx-4 md:my-0">Profile</a>
                    <a href="backend/signout.bkd.php" class="my-1 text-gray-800 hover:text-blue-500 md:mx-4 md:my-0">Sign Out</a>
                <?php
                }
                ?>

            </div>
        </div>
    </nav>
    <?php
    if (isset($_GET['jobID'])) {
        $jobID = (int)$_GET['jobID'];



        $studentsQuery = mysqli_query($conn, "SELECT student.studentID, student.imageURL, college.logoURL, student.name as studentName, stream.name as streamName, student.collegeID, college.name as collegeName, city.cityID, city.name as cityName, state.stateID, state.name as stateName, student.streamYear FROM jobandstudent, student, college, city, state, stream WHERE jobandstudent.jobID = '".$jobID."' AND student.studentID = jobandstudent.studentID AND college.collegeID = student.collegeID AND city.cityID = college.cityID AND state.stateID = college.stateID AND stream.streamID = student.streamID ;");

        if(!$studentsQuery) {
            $result = mysqli_error($conn);
            echo $result;
        }
        while($studentsArr = mysqli_fetch_array($studentsQuery)) {
            ?>
            <div class="max-w-xl my-5 mx-auto px-4 py-4 bg-white shadow-md rounded-lg">
                <div class="flex flex-row justify-evenly">
                    <div>
                        <a href="student.php?studentID=<?= $studentsArr['studentID'] ?>" target="_blank"><img class="rounded-full h-14 w-14" src="<?= $studentsArr['imageURL'] ?>" /></a>

                    </div>
                    <div class="mt-3 mx-5 text-center">
                        <p class=" text-black font-bold"><?= $studentsArr['studentName'] ?></p>
                        <p class=" text-black font-light text-xs"><a href="studentsList.php?streamYear=<?= $studentsArr['streamYear'] ?>" target="_blank"><?= $studentsArr['streamYear'] ?></a> . <a href="studentsList.php?streamID=<?= $streamID ?>" target="_blank"><?= $studentsArr['streamName'] ?></a></p>
                    </div>
                    <div>

                    </div>
                </div>
            </div>
            <?php

        }
    }
        ?>
</body>
</html>
