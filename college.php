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
    <title>college</title>
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
    if (isset($_GET['collegeID'])) {
        $collegeID = (int)$_GET['collegeID'];

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
                            <p class="m-3 text-center text-sm text-gray-700 font-medium"><?= $collegeArr['cityName'] ?> .
                                <?= $collegeArr['stateName'] ?></p>
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
    } ?>

</body>

</html>