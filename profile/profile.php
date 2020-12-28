<?php
require '../backend/db.php';
session_start();
$studentID = $collegeID = $companyID = 0;
if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) {
    if ($_SESSION['userType'] === 'student') {
        $studentID = $_SESSION['userID'];
    } else if ($_SESSION['userType'] === 'college') {
        $collegeID = $_SESSION['userID'];
    } else if ($_SESSION['userType'] === 'companyID') {
        $companyID = $_SESSION['userID'];
    }
}
?>


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
                    <a href="profile/profile.php" class="my-1 text-gray-800 hover:text-blue-500 md:mx-4 md:my-0">Profile</a>
                    <a href="#" class="my-1 text-gray-800 hover:text-blue-500 md:mx-4 md:my-0">Sign Out</a>
                <?php
                }
                ?>

            </div>
        </div>
    </nav>
    <?php
    if ($studentID !== 0) {
        $studentQuery = mysqli_query($conn, "SELECT student.name as studentName, student.streamYear, college.name as collegeName, stream.name as streamName, city.name as cityName FROM student, college, stream, city WHERE student.studentID = $studentID AND college.collegeID = student.collegeID AND stream.streamID = student.streamID AND college.cityID = city.cityID");

        while ($studentArr = mysqli_fetch_array($studentQuery)) {
    ?>
            <div class="container mx-auto mt-20 pt-5">
                <div>

                    <div class="bg-white relative shadow-xl w-5/6 md:w-4/6  lg:w-3/6 xl:w-2/6 mx-auto">
                        <div class="flex justify-center">
                            <img src="https://randomuser.me/api/portraits/women/39.jpg" alt="" class="rounded-full mx-auto absolute -top-20 w-32 h-32 shadow-2xl border-4 border-white">
                        </div>
                        <!-- https://pantazisoft.com/img/avatar-2.jpeg -->
                        <div class="mt-16">
                            <h1 class="font-bold text-center text-3xl text-gray-900"><?= $studentArr['studentName'] ?></h1>
                            <p class="text-center text-sm text-gray-400 font-medium"><?= $studentArr['streamYear'] ?> Year . <?= $studentArr['streamName'] ?></p>
                            <p class="text-center text-sm text-gray-400 font-medium"><?= $studentArr['collegeName'] ?></p>
                            <div class="mt-6 pt-3 flex flex-wrap mx-6 border-t">
                                <div class="text-xs mr-2 my-1 uppercase tracking-wider border px-2 text-indigo-600 border-indigo-600 hover:bg-indigo-600 hover:text-indigo-100 cursor-default">
                                    User experience
                                </div>
                                <div class="text-xs mr-2 my-1 uppercase tracking-wider border px-2 text-indigo-600 border-indigo-600 hover:bg-indigo-600 hover:text-indigo-100 cursor-default">
                                    VueJS
                                </div>
                                <div class="text-xs mr-2 my-1 uppercase tracking-wider border px-2 text-indigo-600 border-indigo-600 hover:bg-indigo-600 hover:text-indigo-100 cursor-default">
                                    TailwindCSS
                                </div>
                                <div class="text-xs mr-2 my-1 uppercase tracking-wider border px-2 text-indigo-600 border-indigo-600 hover:bg-indigo-600 hover:text-indigo-100 cursor-default">
                                    React
                                </div>
                                <div class="text-xs mr-2 my-1 uppercase tracking-wider border px-2 text-indigo-600 border-indigo-600 hover:bg-indigo-600 hover:text-indigo-100 cursor-default">
                                    Painting
                                </div>
                            </div>
                            <div class="flex justify-evenly my-5">
                                <a href="" class="bg font-bold text-sm  w-full text-center py-3 bg-blue-800 text-white shadow-lg">Facebook</a>
                                <a href="" class="bg font-bold text-sm  w-full text-center py-3 bg-blue-400 text-white shadow-lg">Twitter</a>
                                <a href="" class="bg font-bold text-sm  w-full text-center py-3 bg-yellow-600 text-white shadow-lg">Instagram</a>
                                <a href="" class="bg font-bold text-sm  w-full text-center py-3 bg-gray-600 text-white shadow-lg">Email</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php
        }
    } else if ($collegeID !== 0) {
        ?>

    <?php
    } else {
    ?>
    <?php
    }
    ?>

</body>

</html>