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
    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex-shrink-0 flex items-center">
                        <p class="mt-1 text-white font-black text-2xl">cassemble</p>
                    </div>
                    <div class="mt-1 hidden sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <a href="index.php" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium uppercase">slates</a>
                            <a href="jobs.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium uppercase">jobs</a>
                            <a href="events.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium uppercase">events</a>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <?php
                    if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) {
                        $idString = 'ID';
                        $idColumn = $userType . $idString;
                        echo $userTypeID;
                        $userQuery = mysqli_query($conn, "SELECT * FROM $userType WHERE $idColumn = $userID");
                        if (!$userQuery) {
                            $result = mysqli_error($userQuery);
                            header('Location: index.php?error=' . $result);
                            exit();
                        }
                        while ($userArr = mysqli_fetch_array($userQuery)) {
                    ?>
                            <div class="ml-3 relative">
                                <div>
                                    <button class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu" aria-haspopup="true">
                                        <span class="sr-only">Open user menu</span>
                                        <a href="profile/myProfile.php"><img class="h-8 w-8 rounded-full" src="<?= $userArr['imageURL'] ?>" alt=""></a>
                                    </button>
                                </div>
                            </div>
                            <div class="ml-3 relative">
                                <div>
                                    <button class="ml-3 bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu" aria-haspopup="true">
                                        <span class="sr-only">Open user menu</span>
                                        <a href="backend/signout.bkd.php"><img class="h-5 w-5 " src="public/icons/log-out.svg" alt=""></a>
                                    </button>
                                </div>
                            </div>

                        <?php

                        }
                        ?>
                    <?php
                    } else {
                    ?>

                    <?php
                    }
                    ?>

                </div>
            </div>
            <div class="hidden sm:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Slates</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Jobs</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Projects</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Events</a>
                </div>
            </div>
    </nav>
    <?php
    if (isset($_GET['streamID']) && isset($_GET['collegeID'])) {
        $streamID = (int)$_GET['streamID'];
        $collegeID = (int)$_GET['collegeID'];


        $studentsQuery = mysqli_query($conn, "SELECT student.studentID, student.imageURL, college.logoURL, student.name as studentName, stream.name as streamName, student.collegeID, college.name as collegeName, city.cityID, city.name as cityName, state.stateID, state.name as stateName, student.streamYear FROM student, stream, college, state, city WHERE student.streamID = '" . $streamID . "' AND stream.streamID = student.streamID AND college.collegeID = student.collegeID AND city.cityID = college.cityID AND state.stateID = college.stateID;");

        while ($studentsArr = mysqli_fetch_array($studentsQuery)) {
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
    } else if (isset($_GET['streamID'])) {
        $streamID = (int)$_GET['streamID'];

        $studentsQuery = mysqli_query($conn, "SELECT student.studentID, student.imageURL, college.logoURL, student.name as studentName, stream.name as streamName, student.collegeID, college.name as collegeName, city.cityID, city.name as cityName, state.stateID, state.name as stateName, student.streamYear FROM student, stream, college, state, city WHERE student.streamID = '" . $streamID . "' AND stream.streamID = student.streamID AND college.collegeID = student.collegeID AND city.cityID = college.cityID AND state.stateID = college.stateID;");

        while ($studentsArr = mysqli_fetch_array($studentsQuery)) {
        ?>
            <h1 class="my-10 text-center text-black font-black text-2xl"><?= $studentsArr['streamName'] ?> Students</h1>
            <div class="max-w-xl my-5 mx-auto px-4 py-4 bg-white shadow-md rounded-lg">
                <div class="flex flex-row justify-evenly">
                    <div>
                        <a href="student.php?studentID=<?= $studentsArr['studentID'] ?>" target="_blank"><img class="rounded-full h-14 w-14" src="<?= $studentsArr['imageURL'] ?>" /></a>

                    </div>
                    <div class="mt-3 mx-5 text-center">
                        <p class=" text-black font-bold"><?= $studentsArr['studentName'] ?></p>
                        <p class=" text-black font-light text-xs"><a href="studentsList.php?streamYear=<?= $studentsArr['streamYear'] ?>" target="_blank"><?= $studentsArr['streamYear'] ?></a> . <a href="studentsList.php?collegeID=<?= $studentsArr['collegeID'] ?>&streamID=<?= $streamID ?>" target="_blank"><?= $studentsArr['collegeName'] ?></a> . <a href="studentsList.php?cityID=<?= $studentsArr['cityID'] ?>" target="_blank"><?= $studentsArr['cityName'] ?></a> . <a href="studentsList.php?stateID=<?= $studentsArr['stateID'] ?>" target="_blank"><?= $studentsArr['stateName'] ?></a></p>
                    </div>
                    <div>
                        <a href="college.php?collegeID=<?= $studentsArr['collegeID'] ?>" target="_blank"><img class="rounded-full h-14 w-14" src="<?= $studentsArr['logoURL'] ?>" /></a>

                    </div>
                </div>
            </div>

        <?php
        }
    } else if (isset($_GET['streamYear']) && isset($_GET['collegeID'])) {
        $streamYear = $_GET['streamYear'];
        $collegeID = (int)$_GET['collegeID'];

        $studentsQuery = mysqli_query($conn, "SELECT student.studentID, student.imageURL, college.logoURL, student.name as studentName, stream.name as streamName, student.collegeID, college.name as collegeName, city.cityID, city.name as cityName, state.stateID, state.name as stateName, student.streamYear FROM student, stream, college, state, city WHERE student.streamYear = '" . $streamYear . "' AND stream.streamID = student.streamID AND college.collegeID = student.collegeID AND city.cityID = college.cityID AND state.stateID = college.stateID;");

        while ($studentsArr = mysqli_fetch_array($studentsQuery)) {
        ?>
            <h1 class="my-10 text-center text-black font-black text-2xl"><?= $streamYear ?> Year Students</h1>
            <div class="max-w-xl my-5 mx-auto px-4 py-4 bg-white shadow-md rounded-lg">
                <div class="flex flex-row justify-evenly">
                    <div>
                        <a href="student.php?studentID=<?= $studentsArr['studentID'] ?>" target="_blank"><img class="rounded-full h-14 w-14" src="<?= $studentsArr['imageURL'] ?>" /></a>

                    </div>
                    <div class="mt-3 mx-5 text-center">
                        <p class=" text-black font-bold"><?= $studentsArr['studentName'] ?></p>
                        <p class=" text-black font-light text-xs"><a href="studentsList.php?streamYear=<?= $studentsArr['streamYear'] ?>" target="_blank"><?= $studentsArr['streamYear'] ?></a> . <a href="studentsList.php?collegeID=<?= $studentsArr['collegeID'] ?>&streamID=<?= $streamID ?>" target="_blank"><?= $studentsArr['collegeName'] ?></a> . <a href="studentsList.php?cityID=<?= $studentsArr['cityID'] ?>" target="_blank"><?= $studentsArr['cityName'] ?></a> . <a href="studentsList.php?stateID=<?= $studentsArr['stateID'] ?>" target="_blank"><?= $studentsArr['stateName'] ?></a></p>
                    </div>
                    <div>
                        <a href="college.php?collegeID=<?= $studentsArr['collegeID'] ?>" target="_blank"><img class="rounded-full h-14 w-14" src="<?= $studentsArr['logoURL'] ?>" /></a>

                    </div>
                </div>
            </div>

        <?php
        }
    } else if (isset($_GET['cityID'])) {
        $cityID = (int)$_GET['cityID'];

        $studentsQuery = mysqli_query($conn, "SELECT student.studentID, student.imageURL, college.logoURL, student.name as studentName, stream.name as streamName, student.collegeID, college.name as collegeName, city.cityID, city.name as cityName, state.stateID, state.name as stateName, student.streamYear FROM student, stream, college, state, city WHERE city.cityID = $cityID AND college.collegeID = student.collegeID AND city.cityID = college.cityID AND state.stateID = college.stateID;");

        while ($studentsArr = mysqli_fetch_array($studentsQuery)) {
        ?>
            <!-- <h1 class="my-10 text-center text-black font-black text-2xl"><?= $studentsArr['cityName'] ?> Students</h1> -->
            <div class="max-w-xl my-5 mx-auto px-4 py-4 bg-white shadow-md rounded-lg">
                <div class="flex flex-row justify-evenly">
                    <div>
                        <a href="student.php?studentID=<?= $studentsArr['studentID'] ?>" target="_blank"><img class="rounded-full h-14 w-14" src="<?= $studentsArr['imageURL'] ?>" /></a>

                    </div>
                    <div class="mt-3 mx-5 text-center">
                        <p class=" text-black font-bold"><?= $studentsArr['studentName'] ?></p>
                        <p class=" text-black font-light text-xs"><a href="studentsList.php?streamYear=<?= $studentsArr['streamYear'] ?>" target="_blank"><?= $studentsArr['streamYear'] ?></a> . <a href="studentsList.php?collegeID=<?= $studentsArr['collegeID'] ?>&streamID=<?= $streamID ?>" target="_blank"><?= $studentsArr['collegeName'] ?></a> . <a href="studentsList.php?cityID=<?= $studentsArr['cityID'] ?>" target="_blank"><?= $studentsArr['cityName'] ?></a> . <a href="studentsList.php?stateID=<?= $studentsArr['stateID'] ?>" target="_blank"><?= $studentsArr['stateName'] ?></a></p>
                    </div>
                    <div>
                        <a href="college.php?collegeID=<?= $studentsArr['collegeID'] ?>" target="_blank"><img class="rounded-full h-14 w-14" src="<?= $studentsArr['logoURL'] ?>" /></a>

                    </div>
                </div>
            </div>

            <?php
        }
    } else if (isset($_GET['skillID']) && isset($_GET['skillName'])) {
        $skillID = (int)$_GET['skillID'];
        $skillName = $_GET['skillName'];
        $count = 0;
        $printcount = 0;

        $studentandskillQuery = mysqli_query($conn, "SELECT studentID FROM studentandskill WHERE studentandskill.skillID = '" . $skillID . "' ;");

        while ($studentandskillArr = mysqli_fetch_array($studentandskillQuery)) {

            // $studentsSkillsQuery = mysqli_query($conn, "SELECT student.studentID, student.imageURL, college.logoURL, student.name as studentName, stream.name as streamName, student.collegeID, college.name as collegeName, city.cityID, city.name as cityName, state.stateID, state.name as stateName, student.streamYear FROM student, stream, college, state, city WHERE student.studentID = '".$studentandskillArr['studentID']."' AND college.collegeID = student.collegeID AND city.cityID = college.cityID AND state.stateID = college.stateID;");

            $studentsQuery = mysqli_query($conn, "SELECT student.name as studentName, student.imageURL, college.logoURL, college.name as collegeName, city.name as cityName, state.name as stateName, student.streamYear, stream.name as streamName FROM student, college, city, state, stream WHERE student.studentID = '".$studentandskillArr['studentID']."' AND college.collegeID = student.collegeID AND city.cityID = college.cityID AND state.stateID = college.stateID AND stream.streamID = student.streamID ;");
            while ($studentsSkillsArr = mysqli_fetch_array($studentsQuery)) {
                if ($count == 0) {
            ?>
                    <h1 class="my-10 text-center text-black font-black text-2xl"><?= $skillName ?> Students</h1>
                <?php
                    $count++;
                }
                echo $printcount++;
                ?>

                <div class="max-w-xl my-5 mx-auto px-4 py-4 bg-white shadow-md rounded-lg">
                    <div class="flex flex-row justify-evenly">
                        <div>
                            <a href="student.php?studentID=<?= $studentsSkillsArr['studentID'] ?>" target="_blank"><img class="rounded-full h-14 w-14" src="<?= $studentsSkillsArr['imageURL'] ?>" /></a>
                        </div>
                        <div class="mt-3 mx-5 text-center">
                            <p class=" text-black font-bold"><?= $studentsSkillsArr['studentName'] ?></p>
                            <p class=" text-black font-light text-xs"><a href="studentsList.php?streamYear=<?= $studentsSkillsArr['streamYear'] ?>" target="_blank"><?= $studentsSkillsArr['streamYear'] ?></a> . <a href="studentsList.php?collegeID=<?= $studentsSkillsArr['collegeID'] ?>&streamID=<?= $streamID ?>" target="_blank"><?= $studentsSkillsArr['collegeName'] ?></a> . <a href="studentsList.php?cityID=<?= $studentsSkillsArr['cityID'] ?>" target="_blank"><?= $studentsSkillsArr['cityName'] ?></a> . <a href="studentsList.php?stateID=<?= $studentsSkillsArr['stateID'] ?>" target="_blank"><?= $studentsSkillsArr['stateName'] ?></a></p>
                        </div>
                        <div>
                            <a href="college.php?collegeID=<?= $studentsSkillsArr['collegeID'] ?>" target="_blank"><img class="rounded-full h-14 w-14" src="<?= $studentsSkillsArr['logoURL'] ?>" /></a>

                        </div>
                    </div>
                </div>
    <?php
            }
        }
    }
    ?>
</body>

</html>