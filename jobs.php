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
    <title>jobs</title>
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
                            <a href="jobs.php" class=" bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium uppercase">jobs</a>
                            <a href="events.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium uppercase">events</a>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <?php
                    if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) {
                        $idString = 'ID';
                        $idColumn = $userType . $idString;
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

                                        <?php
                                        if ($userType == 'college' || $userType == 'company') {
                                        ?>
                                            <a href="profile/myProfile.php"><img class="h-8 w-8 rounded-full" src="<?= $userArr['logoURL'] ?>" alt=""></a>
                                        <?php
                                        } else {
                                        ?> <a href="profile/myProfile.php"><img class="h-8 w-8 rounded-full" src="<?= $userArr['imageURL'] ?>" alt=""></a>

                                        <?php
                                        }
                                        ?> </button>
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
                    <a href="#" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium">Job</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Projects</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Events</a>
                </div>
            </div>
    </nav>
    <?php
    if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) {
        if ($userType == 'company') {
    ?>
            <div class="max-w-xl mx-auto mt-5 px-4 py-4 bg-white shadow-md rounded-lg">
                <div class="uppercase text-l font-bold text-center">
                    Create a Job
                </div>
                <form action="backend/addJob.bkd.php" method="POST">
                    <input type="hidden" name="companyID" value="<?php echo htmlspecialchars($companyID); ?>">
                    <label for="title" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Title</label>
                    <input id="title" type="text" name="title" placeholder="Lead Android Developer" autocomplete="title" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                    <div class="border-gray-900 my-2">

                        <label for="jobDescription" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Job Description</label>
                        <textarea ] name="jobDescription" placeholder="As a Lead Android Developer, you will have to..." class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required id="jobDescription" cols="100" rows="3"></textarea>
                    </div>
                    <button type="submit" name="submit-job" class="w-full font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">Create</button>
                </form>
            </div>
            <?php
        }

        $jobsQuery = mysqli_query($conn, "SELECT * FROM job ORDER BY createdAt DESC");

        while ($jobsArr = mysqli_fetch_array($jobsQuery)) {
            $jobID = $jobsArr['jobID'];

            $companyQuery = mysqli_query($conn, "SELECT company.name, company.logoURL, company.headquarters FROM company WHERE company.companyID = '" . $jobsArr['companyID'] . "' ;");

            while ($companyArr = mysqli_fetch_array($companyQuery)) {
            ?>
                <div class="max-w-xl my-5 mx-auto px-4 py-4 bg-white shadow-md rounded-lg">
                    <div class="flex flex-row items-center">
                        <a href="company.php?companyID=<?= $jobsArr['companyID'] ?>" target="_blank"><img class="rounded-full h-10 w-10" src="<?= $companyArr['logoURL'] ?>" /></a>
                        <div class="ml-5">
                            <a href="company.php?companyID=<?= $jobsArr['companyID'] ?>" target="_blank">
                                <p class=" text-black font-bold"><?= $jobsArr['title'] ?></p>
                            </a>
                            <p class=" text-black font-light text-sm"><?= $companyArr['name'] ?> . <?= $companyArr['headquarters'] ?></p>
                        </div>
                        <?php
                        $jobPostedTime;
                        date_default_timezone_set('Asia/Kolkata');
                        $time_ago = strtotime($jobsArr['createdAt']);
                        $current_time = time();
                        $time_difference = $current_time - $time_ago;
                        $seconds = $time_difference;
                        $minutes = round($seconds / 60);
                        $hours = round($seconds / 3600);
                        $days = round($seconds / 86400);
                        $weeks = round($seconds / 604800);
                        $months = round($seconds / 2629440);
                        $years = round($seconds / 31553280);
                        if ($seconds <= 60) {
                            $jobPostedTime = "NOW";
                        } else if ($minutes <= 60) {
                            if ($minutes == 1) {
                                $jobPostedTime = "1 min";
                            } else {
                                $jobPostedTime = "$minutes mins";
                            }
                        } else if ($hours <= 24) {
                            if ($hours == 1) {
                                $jobPostedTime = "1 hr";
                            } else {
                                $jobPostedTime = "$hours hrs";
                            }
                        } else if ($days <= 7) {
                            if ($days == 1) {
                                $jobPostedTime = "yesterday";
                            } else {
                                $jobPostedTime = "$days d";
                            }
                        } else if ($weeks <= 4.3) //4.3 == 52/12  
                        {
                            if ($weeks == 1) {
                                $jobPostedTime = "1 w";
                            } else {
                                $jobPostedTime = "$weeks w";
                            }
                        } else if ($months <= 12) {
                            if ($months == 1) {
                                $jobPostedTime = "1 m";
                            } else {
                                $jobPostedTime = "$months m";
                            }
                        } else {
                            if ($years == 1) {
                                $jobPostedTime = "1 y";
                            } else {
                                $jobPostedTime = "$years y";
                            }
                        }
                        ?>
                        <div class="pt-5 mr-2 ml-auto">
                            <p class="mb-5 text-black font-light text-xs"><?= $jobPostedTime ?></p>
                        </div>

                        <div>
                            <div class="slateMenuButton inline-block relative">
                                <img class="w-3 slateMenuButton" src="public/icons/ellipsis.svg" data-id="<?php echo $jobsArr['jobID']; ?>" alt="" srcset="">
                                <ul class="slateMenu absolute hidden text-gray-700 pt-1">
                                    <?php
                                    if ($jobsArr['companyID'] == $userID) { ?>
                                        <li class=""><a onclick="copyToClipboard" class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="https://wa.me/?text=https://localhost/cassemble/job.php?jobID=<?php echo $jobsArr['jobID'] ?>">Share</a></li>
                                        <li class=""><a class=" bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="applicants.php?jobID=<?php echo $jobsArr['jobID'] ?>">See Applicants</a></li>
                                        <li class=""><a class="rounded-b bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="backend/deleteJob.php?jobID=<?php echo $jobsArr['jobID'] ?>">Delete</a></li>
                                    <?php
                                    } else {
                                    ?>
                                        <li class=""><a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="#">Share</a></li>
                                        <li class=""><a class="rounded-b bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="#">Report</a></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <style>
                            .slateMenuButton:hover .slateMenu {
                                display: block;
                            }
                        </style>
                    </div>
                    <div class="jobContent overflow-auto my-5 mx-5 font-normal text-justify"><?= nl2br($jobsArr['content']) ?></div>
                    <?php
                    if ($userType == 'student') {
                    ?>
                        <div class="flex justify-evenly text-center actionBar">
                            <div class="flex">
                                <?php
                                $bookmarkedQuery = mysqli_query($conn, "SELECT * FROM bookmarks WHERE jobID = '" . $jobsArr['jobID'] . "' AND companyID = '" . $userID . "' ;");

                                if ($bookmarkedArr = mysqli_fetch_array($bookmarkedQuery)) {
                                ?>
                                    <img class="w-5 bookmark" src="public/icons/bookmark.svg" data-id="<?php echo $jobsArr['jobID']; ?>" alt="" srcset="">
                                    <img class="w-5 bookmarko hidden" src="public/icons/bookmark-o.svg" data-id="<?php echo $jobsArr['jobID']; ?>" alt="" srcset="">
                                <?php
                                } else {
                                ?>
                                    <img class="w-5 bookmarko" src="public/icons/bookmark-o.svg" data-id="<?php echo $jobsArr['jobID']; ?>" alt="" srcset="">
                                    <img class="w-5 bookmark hidden" src="public/icons/bookmark.svg" data-id="<?php echo $jobsArr['jobID']; ?>" alt="" srcset="">
                                <?php
                                }
                                ?>
                            </div>
                            <?php
                            $appliedQuery = mysqli_query($conn, "SELECT * FROM jobandstudent WHERE jobID = '" . $jobsArr['jobID'] . "' AND studentID = '" . $userID . "' ;");

                            if ($appliedArr = mysqli_fetch_array($appliedQuery)) {
                            ?>
                                <button class="applied uppercase shadow bg-gray-400 hover:bg-gray-900 focus:shadow-outline focus:outline-none text-white text-xs px-3 py-2 rounded-3xl" data-id="<?php echo $jobsArr['jobID']; ?>">APPLIED</button>
                                <button class="apply hidden uppercase shadow bg-red-500 hover:bg-green-900 focus:shadow-outline focus:outline-none text-white text-xs px-3 py-2 rounded-3xl" data-id="<?php echo $jobsArr['jobID']; ?>">APPLY</button>
                            <?php
                            } else {
                            ?>
                                <button class="applied hidden uppercase shadow bg-gray-400 hover:bg-gray-900 focus:shadow-outline focus:outline-none text-white text-xs px-3 py-2 rounded-3xl" data-id="<?php echo $jobsArr['jobID']; ?>">APPLIED</button>
                                <button class="apply uppercase shadow bg-red-500 hover:bg-green-900 focus:shadow-outline focus:outline-none text-white text-xs px-3 py-2 rounded-3xl" data-id="<?php echo $jobsArr['jobID']; ?>">APPLY</button>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    } ?>
                </div>

    <?php
            }
        }
    }
    ?>
    <script>
        $(document).ready(function() {

            $('.bookmarko').click(function() {
                var jobID = $(this).data('id');
                $job = $(this);
                $.ajax({
                    url: 'backend/bookmark.php',
                    type: 'post',
                    data: {
                        'bookmarkJob': 1,
                        'jobID': jobID
                    },
                    success: function(res) {
                        console.log(res);
                        $job.addClass('hidden');
                        $job.siblings().removeClass('hidden');
                    }
                });
            });

            $('.bookmark').click(function() {
                var jobID = $(this).data('id');
                $job = $(this);
                $.ajax({
                    url: 'backend/bookmark.php',
                    type: 'post',
                    data: {
                        'unbookmarkJob': 1,
                        'jobID': jobID
                    },
                    success: function(res) {
                        $job.addClass('hidden');
                        $job.siblings().removeClass('hidden');
                    }
                });
            });

            $('.apply').click(function() {
                var jobID = $(this).data('id');
                $job = $(this);
                $.ajax({
                    url: 'backend/bookmark.php',
                    type: 'post',
                    data: {
                        'applyForJob': 1,
                        'jobID': jobID
                    },
                    success: function(res) {
                        $job.addClass('hidden');
                        $job.siblings().removeClass('hidden');
                    }
                });
            });
        });
    </script>
</body>

</html>