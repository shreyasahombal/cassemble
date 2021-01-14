<?php
require '../backend/db.php';
session_start();
$studentID = $collegeID = $collegeID = $id = 0;
$userType;
if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) {
    if ($_SESSION['userType'] === 'student') {
        $studentID = $_SESSION['userID'];
        $userType = 'student';
    } else if ($_SESSION['userType'] === 'college') {
        $collegeID = $_SESSION['userID'];
        $userType = 'college';
    } else if ($_SESSION['userType'] === 'college') {
        $collegeID = $_SESSION['userID'];
        $userType = 'college';
    }
    $userID = $_SESSION['userID'];
}?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../public/build/tailwind.css" type="text/css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Profile</title>
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
                            <a href="index.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium uppercase">slates</a>
                            <a href="jobs.php" class="text-gray-300 hover:bg-gray-700 hover:text-white   px-3 py-2 rounded-md text-sm font-medium uppercase">jobs</a>
                            <a href="events.php" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium uppercase">events</a>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <?php
                    if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) {
                        $idString = 'ID';
                        $idColumn = $userType . $idString;
                        $userQuery = mysqli_query($conn, "SELECT * FROM $userType WHERE $idColumn = '".$userID."' ;");
                        if (!$userQuery) {
                            $result = mysqli_error($conn);
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
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Job</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Projects</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Events</a>
                </div>
            </div>
    </nav>
    <?php
    if ($studentID !== 0) {
        $studentQuery = mysqli_query($conn, "SELECT student.name as studentName, student.githubURL, student.resumeURL, student.twitterURL, student.streamYear, student.imageURL as studentImage, college.name as collegeName, stream.name as streamName, city.name as cityName FROM student, college, stream, city WHERE student.studentID = $studentID AND college.collegeID = student.collegeID AND stream.streamID = student.streamID AND college.cityID = city.cityID");

        while ($studentArr = mysqli_fetch_array($studentQuery)) {
    ?>
    <div class="container mx-auto mt-20 pt-5">
        <div>

            <div class="bg-white relative shadow-xl w-5/6 md:w-4/6  lg:w-3/6 xl:w-2/6 mx-auto">
                <div class="flex justify-center">
                    <img src="<?= $studentArr['studentImage'] ?>" alt="" class="rounded-full mx-auto absolute -top-20 w-32 h-32 shadow-2xl border-4 border-white">
                </div>
                <!-- https://pantazisoft.com/img/avatar-2.jpeg -->
                <div class="mt-16">
                    <h1 class="font-bold text-center text-3xl text-gray-900"><?= $studentArr['studentName'] ?></h1>
                    <p class="m-3 text-center text-sm text-gray-700 font-medium"><?= $studentArr['streamYear'] ?> Year . <?= $studentArr['streamName'] ?></p>
                    <p class="text-center text-sm text-gray-900 font-medium"><?= $studentArr['collegeName'] ?></p>
                    <div class="mt-6 pt-3 flex flex-wrap mx-6 border-t justify-center">
                        <?php
                        $studentandskillQuery = mysqli_query($conn, "SELECT skillID FROM studentandskill WHERE studentID = $studentID LIMIT 3;");
                        while ($studentandskillArr = mysqli_fetch_array($studentandskillQuery)) {
                            $skillQuery = mysqli_query($conn, "SELECT name, skillID FROM skill WHERE skillID='" . $studentandskillArr['skillID'] . "';");
                            if ($skillQuery == false) {
                                die('Error: ' . mysqli_error($conn));
                            } else {
                                while ($skillArr = mysqli_fetch_array($skillQuery)) {
                        ?>
                                    <div class="text-xs mr-2 my-1 uppercase tracking-wider border px-2 text-indigo-600 border-indigo-600 hover:bg-indigo-600 hover:text-indigo-100 cursor-default">
                                    <a href="../studentsList.php?skillID=<?=$skillArr['skillID']?>&skillName=<?=$skillArr['name']?>">
                                        <?= $skillArr['name'] ?>
                                    </a>
                                    </div>
                        <?php
                                }
                            }
                        }
                        ?>
                    </div>
                    <div class="mt-3 flex mx-6 border-t justify-center"></div>

                    <div class=" pt-3 flex flex-wrap mx-6 justify-center">
                    <a href="../slates.php?studentID=<?=$studentID?>">
                        <button class="uppercase p-3 flex items-center bg-blue-600 text-blue-50 max-w-max shadow-sm hover:shadow-lg rounded-full w-12 h-12 ">
                            <img class="bg-blue-100" src="../public/icons/post.svg" alt="">
                        </button>
                    </a>
                        <div class="uppercase font-normal ml-5 pt-3">
                        SLATES
                        </div>
                    </div>

                        
                    <div class="mt-3 flex mx-6 border-t justify-center"></div>
                    
                    <div class=" pt-3 flex flex-wrap mx-6 justify-center">
                    <a href="../bookmarks.php?studentID=<?=$studentID?>">

                        <button class="uppercase p-3 flex items-center bg-red-600 text-blue-50 max-w-max shadow-sm hover:shadow-lg rounded-full w-12 h-12 ">
                            <img class="bg-red-600 w-7 h-7" src="../public/icons/bookmark-o.svg" alt="">
                        </button>
                    </a>
                        <div class="uppercase font-normal ml-5 pt-3">
                        BOOKMARKS
                        </div>
                    </div>

                    <div class="flex justify-evenly my-5">
                        <a href="<?= $studentArr['githubURL'] ?>" target="_blank" class="bg font-bold text-sm  w-full text-center py-3 bg-gray-600 text-white shadow-lg">Github</a>
                        <a href="<?= $studentArr['resumeURL'] ?>" target="_blank" class="bg font-bold text-sm  w-full text-center py-3 bg-yellow-600 text-white shadow-lg">Resume</a>
                        <a href="<?= $studentArr['twitterURL'] ?>" target="_blank" class="bg font-bold text-sm  w-full text-center py-3 bg-blue-400 text-white shadow-lg">Twitter</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
        <?php
        }
    } else if ($collegeID !== 0) {
        $collegeQuery = mysqli_query($conn, "SELECT college.name as collegeName, college.logoURL, city.name as cityName, college.websiteURL, state.name as stateName FROM college, city, state WHERE college.collegeID = $collegeID AND city.cityID = college.cityID AND state.stateID = college.stateID");

        while ($collegeArr = mysqli_fetch_array($collegeQuery)) {
        ?>
            <div class="container mx-auto mt-20 pt-5">
                <div>

                    <div class="bg-white relative shadow-2xl w-5/6 md:w-4/6  lg:w-3/6 xl:w-2/6 mx-auto">
                        <div class="flex justify-center">
                            <img src="<?= $collegeArr['logoURL'] ?>" alt="" class="rounded-full mx-auto absolute -top-20 w-32 h-32 shadow-2xl ">
                        </div>
                        <!-- https://pantazisoft.com/img/avatar-2.jpeg -->
                        <div class="mt-16">
                            <h1 class="font-bold text-center text-3xl text-gray-900"><?= $collegeArr['collegeName'] ?></h1>
                            <p class="m-3 text-center text-sm text-gray-700 font-medium"><?= $collegeArr['cityName'] ?> . <?= $collegeArr['stateName'] ?></p>
                            <!-- <p class="text-center text-sm text-gray-900 font-medium"><?= $collegeArr['stateName'] ?></p> -->
                            <div class="mt-6 pt-3 flex flex-wrap mx-6 border-t justify-center">
                                <?php
                                $collegeandstreamQuery = mysqli_query($conn, "SELECT streamID FROM collegeandstream WHERE collegeID = $collegeID;");
                                while ($collegeandstreamArr = mysqli_fetch_array($collegeandstreamQuery)) {
                                    $streamQuery = mysqli_query($conn, "SELECT name FROM stream WHERE streamID='" . $collegeandstreamArr['streamID'] . "';");
                                    if ($streamQuery == false) {
                                        die('Error: ' . mysqli_error($conn));
                                    } else {
                                        while ($streamArr = mysqli_fetch_array($streamQuery)) {
                                ?>
                                            <div class="text-xs mr-2 my-1 uppercase tracking-wider border px-2 text-indigo-600 border-indigo-600 hover:bg-indigo-600 hover:text-indigo-100 cursor-default">
                                                <?= $streamArr['name'] ?>
                                            </div>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </div>

                            <div class="flex justify-evenly my-5">
                                <a href="<?= $collegeArr['websiteURL'] ?>" target="_blank" class="bg font-bold text-sm  w-full text-center py-3 bg-blue-700 text-white shadow-lg">Website</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php
        }
    } else {
        $companyQuery = mysqli_query($conn, "SELECT company.name, company.headquarters, company.description, company.logoURL, company.websiteURL FROM company WHERE companyID = $companyID;");

        while ($companyArr = mysqli_fetch_array($companyQuery)) {
        ?>
            <div class="container mx-auto mt-20 pt-5">
                <div>

                    <div class="bg-white relative shadow-xl w-5/6 md:w-4/6  lg:w-3/6 xl:w-2/6 mx-auto">
                        <div class="flex justify-center">
                            <img src="<?= $companyArr['logoURL'] ?>" alt="" class="rounded-full mx-auto absolute -top-20 w-32 h-32 shadow-2xl border-4 border-white">
                        </div>
                        <!-- https://pantazisoft.com/img/avatar-2.jpeg -->
                        <div class="mt-16">
                            <h1 class="font-bold text-center text-3xl text-gray-900"><?= $companyArr['name'] ?></h1>
                            <p class="m-3 text-center text-sm text-gray-700 font-medium"><?= $companyArr['headquarters'] ?></p>
                            <div class="mt-6 pt-3 flex flex-wrap mx-6 border-t justify-center">
                                <div class="text-center font-light">
                                    <?= $companyArr['description'] ?>
                                </div>
                            </div>

                            <div class="flex justify-evenly my-5">
                                <a href="<?= $companyArr['websiteURL'] ?>" target="_blank" class="bg font-bold text-sm  w-full text-center py-3 bg-blue-700 text-white shadow-lg">Website</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    <?php
        }
    }
    ?>

</body>

</html>