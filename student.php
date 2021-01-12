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
    <title>student</title>
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
                    <a href="backend/signout.bkd.php" class="my-1 text-gray-800 hover:text-blue-500 md:mx-4 md:my-0">Sign
                        Out</a>
                <?php
                }
                ?>
            </div>
        </div>
    </nav>
    <?php
    if (isset($_GET['studentID'])) {
        $studentID = (int)$_GET['studentID'];

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
                                            <a href="studentsList.php?skillID=<?=$skillArr['skillID']?>&skillName=<?=$skillArr['name']?>">
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
                            <a href="slates.php?studentID=<?=$studentID?>">
                                <button class="uppercase p-3 flex items-center bg-blue-600 text-blue-50 max-w-max shadow-sm hover:shadow-lg rounded-full w-12 h-12 ">
                                    <img class="bg-blue-100" src="public/icons/post.svg" alt="">
                                </button>
                            </a>
                                <div class="uppercase font-normal ml-5 pt-3">
                                SLATES
                                </div>
                            </div>

                                
                            <div class="mt-3 flex mx-6 border-t justify-center"></div>
                            
                            <div class=" pt-3 flex flex-wrap mx-6 justify-center">
                            <a href="bookmarks.php?studentID=<?=$studentID?>">

                                <button class="uppercase p-3 flex items-center bg-red-600 text-blue-50 max-w-max shadow-sm hover:shadow-lg rounded-full w-12 h-12 ">
                                    <img class="bg-red-600 w-7 h-7" src="public/icons/bookmark-o.svg" alt="">
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
    } ?>

</body>

</html>