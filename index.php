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
    <title>cassemble</title>
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
                                        ?>
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
                    <a href="#" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium">Slates</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Jobs</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Projects</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Events</a>
                </div>
            </div>
    </nav>

    <?php
    if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) { ?>

        <div class="max-w-xl mx-auto mt-5 px-4 py-4 bg-white shadow-md rounded-lg">
            <div class="uppercase text-l font-bold text-center">
                Create a Slate
            </div>
            <form action="backend/addSlate.bkd.php" method="POST">
                <input type="hidden" name="studentID" value="<?php echo htmlspecialchars($studentID); ?>">
                <input type="hidden" name="collegeID" value="<?php echo htmlspecialchars($collegeID); ?>">
                <input type="hidden" name="companyID" value="<?php echo htmlspecialchars($companyID); ?>">
                <div class="border-gray-900 mr-20">
                    <textarea class="bg-gray-100" name="content" id="content" cols="66" rows="3"></textarea>
                </div>
                <button type="submit" name="submit-slate" class="w-full font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">Done</button>
            </form>
        </div>
        <?php
        $slatesQuery = mysqli_query($conn, "SELECT * FROM slate ORDER BY createdAt DESC");

        while ($slatesArr = mysqli_fetch_array($slatesQuery)) {
            $slateID = $slatesArr['slateID'];

            if ($slatesArr['studentID'] !== NULL && $slatesArr['studentID'] !== '') {
                $creatorID = $slatesArr['studentID'];
                $creatorType = 'student';
                $creatorQuery = mysqli_query($conn, "SELECT student.name as creatorName, student.imageURL as creatorImage, student.streamYear, college.name as collegeName, college.collegeID, stream.acronym, city.cityID, stream.streamID, city.name as cityName FROM student, college, stream, city WHERE student.studentID = " . $slatesArr['studentID'] . " AND college.collegeID = student.collegeID AND stream.streamID = student.streamID AND college.cityID = city.cityID");
            }

            if ($slatesArr['collegeID'] !== NULL && $slatesArr['collegeID'] !== '') {
                $creatorID = $slatesArr['collegeID'];
                $creatorType = 'college';
                $creatorQuery = mysqli_query($conn, "SELECT college.name as creatorName, college.logoURL as creatorImage, city.name as cityName, city.cityID, state.name as stateName, state.stateID FROM college, city, state WHERE college.collegeID = " . $slatesArr['collegeID'] . " AND college.cityID = city.cityID AND college.stateID = state.stateID");
            }

            if ($slatesArr['companyID'] !== NULL && $slatesArr['companyID'] !== '') {
                $creatorID = $slatesArr['companyID'];
                $creatorType = 'company';
                $creatorQuery = mysqli_query($conn, "SELECT company.name as creatorName, company.logoURL as creatorImage, company.headquarters as headquarters FROM company WHERE company.companyID = " . $slatesArr['companyID'] . ";");
            }

            if (!$creatorQuery) {
                $result = mysqli_error($conn);
                echo $result;
            }

            while ($creatorArr = mysqli_fetch_array($creatorQuery)) {
        ?>
                <div class="max-w-xl my-5 mx-auto px-4 py-4 bg-white shadow-md rounded-lg">
                    <div class="flex flex-row items-center">
                        <a href="<?= $creatorType ?>.php?<?= $creatorType ?>ID=<?= $creatorID ?>" target="_blank"><img class="rounded-full h-10 w-10" src="<?= $creatorArr['creatorImage'] ?>" /></a>
                        <div class="ml-5">
                            <a href="<?= $creatorType ?>.php?<?= $creatorType ?>ID=<?= $creatorID ?>" target="_blank">
                                <p class=" text-black font-bold"><?= $creatorArr['creatorName'] ?></p>
                            </a>
                            <?php
                            if ($creatorType == 'student') { ?>
                                <p class=" text-black font-light text-xs"><a href="studentsList.php?streamID=<?= $creatorArr['streamID'] ?>&collegeID=<?= $creatorArr['collegeID'] ?>" target="_blank"><?= $creatorArr['acronym'] ?></a> . <a href="studentsList.php?streamYear=<?= $creatorArr['streamYear'] ?>&collegeID=<?= $creatorArr['collegeID'] ?>" target="_blank"><?= $creatorArr['streamYear'] ?></a> . <a href="college.php?collegeID=<?= $creatorArr['collegeID'] ?>" target="_blank"><?= $creatorArr['collegeName'] ?></a> . <a href="studentsList.php?cityID=<?= $creatorArr['cityID'] ?>" target="_blank"><?= $creatorArr['cityName'] ?></a></p>
                            <?php } else if ($creatorType == 'college') { ?>
                                <p class=" text-black font-light text-xs"><a href="collegesList.php?cityID=<?= $creatorArr['cityID'] ?>" target="_blank"> <?= $creatorArr['cityName'] ?> </a> .<a href="collegesList.php?stateID=<?= $creatorArr['stateID'] ?>" target="_blank"> <?= $creatorArr['stateName'] ?></a></p>
                            <?php } else if ($creatorType == 'company') { ?>
                                <p class=" text-black font-light text-xs"> <?= $creatorArr['headquarters'] ?> </p>
                            <?php } ?>
                        </div>
                        <?php
                        $slateTime;
                        date_default_timezone_set('Asia/Kolkata');
                        $time_ago = strtotime($slatesArr['createdAt']);
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
                            $slateTime = "NOW";
                        } else if ($minutes <= 60) {
                            if ($minutes == 1) {
                                $slateTime = "1 min";
                            } else {
                                $slateTime = "$minutes mins";
                            }
                        } else if ($hours <= 24) {
                            if ($hours == 1) {
                                $slateTime = "1 hr";
                            } else {
                                $slateTime = "$hours hrs";
                            }
                        } else if ($days <= 7) {
                            if ($days == 1) {
                                $slateTime = "yesterday";
                            } else {
                                $slateTime = "$days d";
                            }
                        } else if ($weeks <= 4.3) //4.3 == 52/12  
                        {
                            if ($weeks == 1) {
                                $slateTime = "1 w";
                            } else {
                                $slateTime = "$weeks w";
                            }
                        } else if ($months <= 12) {
                            if ($months == 1) {
                                $slateTime = "1 m";
                            } else {
                                $slateTime = "$months m";
                            }
                        } else {
                            if ($years == 1) {
                                $slateTime = "1 y";
                            } else {
                                $slateTime = "$years y";
                            }
                        }
                        ?>
                        <div class="pt-5 mr-2 ml-auto">
                            <p class="mb-5 text-black font-light text-xs"><?= $slateTime ?></p>
                        </div>
                        <div>
                            <div class="slateMenuButton inline-block relative">
                                <img class="w-3 slateMenuButton" src="public/icons/ellipsis.svg" data-id="<?php echo $slatesArr['slateID']; ?>" alt="" srcset="">
                                <ul class="slateMenu absolute hidden text-gray-700 pt-1">
                                    <?php
                                    if ($creatorID == $userID) { ?>
                                        <li class=""><a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="#">Share</a></li>
                                        <li class="editSlateButton rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Edit</li>
                                        <li class=""><a class="rounded-b bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="backend/deleteSlate.php?slateID=<?php echo $slatesArr['slateID']; ?>">Delete</a></li>
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
                    <div class="slateContent my-5 mx-5 font-normal text-justify"><?= $slatesArr['content'] ?></div>
                    <div class="my-5 mx-5 font-normal editSlateBox hidden">
                        <div class="border-gray-900 mr-20 contentInEditSlate">
                            <textarea autofocus class="bg-gray-100" name="content" id="contentInEditSlate" cols="62" rows="5">
                            <?= $slatesArr['content'] ?></textarea>
                        </div>
                        <button type="submit" name="submit-edit-slate" data-id="<?php echo $slatesArr['slateID']; ?>" class="submit-edit-slate w-full font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">Publish Edit</button>
                    </div>
                    <div class="flex justify-evenly text-center actionBar">
                        <div class="flex">
                            <?php
                            $idString = 'ID';
                            $idColumn = $userType . $idString;

                            $bookmarkedQuery = mysqli_query($conn, "SELECT * FROM bookmarks WHERE slateID = " . $slatesArr['slateID'] . " AND $idColumn = $userID ;");

                            if ($bookmarkedArr = mysqli_fetch_array($bookmarkedQuery)) {
                            ?>
                                <img class="w-5 bookmark" src="public/icons/bookmark.svg" data-id="<?php echo $slatesArr['slateID']; ?>" alt="" srcset="">
                                <img class="w-5 bookmarko hidden" src="public/icons/bookmark-o.svg" data-id="<?php echo $slatesArr['slateID']; ?>" alt="" srcset="">
                            <?php
                            } else {
                            ?>
                                <img class="w-5 bookmarko" src="public/icons/bookmark-o.svg" data-id="<?php echo $slatesArr['slateID']; ?>" alt="" srcset="">
                                <img class="w-5 bookmark hidden" src="public/icons/bookmark.svg" data-id="<?php echo $slatesArr['slateID']; ?>" alt="" srcset="">
                            <?php
                            }
                            ?>
                        </div>
                        <div class="replyIconButtons">
                            <img class="w-5 replyo" src="public/icons/reply-o.svg" data-id="<?php echo $slatesArr['slateID']; ?>" alt="" srcset="">
                            <img class="w-5 reply hidden" src="public/icons/reply.svg" data-id="<?php echo $slatesArr['slateID']; ?>" alt="" srcset="">
                        </div>
                    </div>
                    <div class="replybox hidden mt-5">
                        <div class="border-gray-900 mr-20 replyToSlateInputForm">
                            <textarea class="bg-gray-100" name="content" id="contentInReplyToSlate" cols="66" rows="2"></textarea>
                        </div>
                        <button type="submit" name="submit-slate-reply" data-id="<?php echo $slatesArr['slateID']; ?>" class="submit-slate-reply w-full font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">Reply</button>
                        <?php
                        $repliesQuery = mysqli_query($conn, "SELECT * FROM reply WHERE slateID = " . $slatesArr['slateID'] . " ORDER BY createdAt DESC LIMIT 3 ;");

                        while ($repliesArr = mysqli_fetch_array($repliesQuery)) {
                            if ($repliesArr['studentID'] !== NULL && $repliesArr['studentID'] !== '') {
                                $replierID = $repliesArr['studentID'];
                                $replierType = 'student';
                                $replierQuery = mysqli_query($conn, "SELECT student.name as creatorName, student.imageURL as creatorImage, student.streamYear, college.name as collegeName, stream.acronym, city.name as cityName FROM student, college, stream, city WHERE student.studentID = " . $repliesArr['studentID'] . " AND college.collegeID = student.collegeID AND stream.streamID = student.streamID AND college.cityID = city.cityID");
                            }

                            if ($repliesArr['collegeID'] !== NULL && $repliesArr['collegeID'] !== '') {
                                $replierID = $repliesArr['collegeID'];
                                $replierType = 'college';
                                $replierQuery = mysqli_query($conn, "SELECT college.name as creatorName, college.logoURL as creatorImage, city.name as cityName, state.name as stateName FROM college, city, state WHERE college.collegeID = " . $repliesArr['collegeID'] . " AND college.cityID = city.cityID AND college.stateID = state.stateID");
                            }

                            if ($repliesArr['companyID'] !== NULL && $repliesArr['companyID'] !== '') {
                                $replierID = $repliesArr['companyID'];
                                $replierType = 'company';
                                $replierQuery = mysqli_query($conn, "SELECT company.name as creatorName, company.logoURL as creatorImage, company.headquarters as headquarters FROM company WHERE company.companyID = " . $repliesArr['companyID'] . ";");
                            }

                            while ($replierArr = mysqli_fetch_array($replierQuery)) {
                        ?>
                                <div class="max-w-xl my-5 mx-auto px-4 py-4 bg-white shadow-md rounded-lg">
                                    <div class="flex flex-row items-center">
                                        <img class="rounded-full h-8 w-8" src="<?= $replierArr['creatorImage'] ?>" />
                                        <div class="ml-5">
                                            <p class=" text-black text-sm font-semibold"><?= $replierArr['creatorName'] ?></p>
                                            <?php
                                            if ($replierType == 'student') { ?>
                                                <p class=" text-black font-extralight text-xs"><?= $replierArr['acronym'] ?> . <?= $replierArr['streamYear'] ?> . <?= $replierArr['collegeName'] ?> . <?= $replierArr['cityName'] ?></p>
                                            <?php } else if ($replierType == 'college') { ?>
                                                <p class=" text-black font-light text-xs"> <?= $replierArr['cityName'] ?> . <?= $replierArr['stateName'] ?></p>
                                            <?php } else if ($replierType == 'company') { ?>
                                                <p class=" text-black font-light text-xs"> <?= $replierArr['headquarters'] ?> </p>
                                            <?php } ?>
                                        </div>
                                        <?php
                                        $replyTime;
                                        date_default_timezone_set('Asia/Kolkata');
                                        $time_ago = strtotime($repliesArr['createdAt']);
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
                                            $replyTime = "NOW";
                                        } else if ($minutes <= 60) {
                                            if ($minutes == 1) {
                                                $replyTime = "1 min";
                                            } else {
                                                $replyTime = "$minutes mins";
                                            }
                                        } else if ($hours <= 24) {
                                            if ($hours == 1) {
                                                $replyTime = "1 hr";
                                            } else {
                                                $replyTime = "$hours hrs";
                                            }
                                        } else if ($days <= 7) {
                                            if ($days == 1) {
                                                $replyTime = "yesterday";
                                            } else {
                                                $replyTime = "$days d";
                                            }
                                        } else if ($weeks <= 4.3) //4.3 == 52/12  
                                        {
                                            if ($weeks == 1) {
                                                $replyTime = "1 w";
                                            } else {
                                                $replyTime = "$weeks w";
                                            }
                                        } else if ($months <= 12) {
                                            if ($months == 1) {
                                                $replyTime = "1 m";
                                            } else {
                                                $replyTime = "$months m";
                                            }
                                        } else {
                                            if ($years == 1) {
                                                $replyTime = "1 y";
                                            } else {
                                                $replyTime = "$years y";
                                            }
                                        }
                                        ?>
                                        <div class="ml-auto">
                                            <p class="mb-5 text-black font-light text-xs"><?= $replyTime ?></p>
                                        </div>

                                        <div>
                                            <div class="slateMenuButton inline-block relative">
                                                <img class="w-3 slateMenuButton" src="public/icons/ellipsis.svg" data-id="<?php echo $slatesArr['slateID']; ?>" alt="" srcset="">
                                                <ul class="slateMenu absolute hidden text-gray-700 pt-1">
                                                    <?php
                                                    if ($replierID == $userID) { ?>
                                                        <li class=""><a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="#">Share</a></li>
                                                        <li class="editReplyButton bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Edit</li>
                                                        <li class=""><a class="rounded-b bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="backend/deleteReply.php?replyID=<?php echo $repliesArr['replyID']; ?>">Delete</a></li>
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
                                    <div class="replyContent mt-2 mx-10 px-3 font-normal text-justify"><?= $repliesArr['content'] ?></div>
                                    <div class="my-5 mx-5 font-normal editReplyBox hidden">
                                        <div class="my-5 mx-5 font-normal">
                                            <div class="border-gray-900 mr-20 contentInEditReply">
                                                <textarea autofocus class="bg-gray-100" name="content" id="contentInEditReply" cols="52" rows="5">
                                                    <?= $repliesArr['content'] ?>
                                                </textarea>
                                            </div>
                                            <button type="submit" name="submit-edit-reply" data-id="<?php echo $repliesArr['replyID']; ?>" class="submit-edit-reply w-full font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">Publish Edited reply</button>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
        <?php
            }
        }
    } else { ?><div class="relative bg-white overflow-hidden">
            <div class="max-w-7xl mx-auto">


                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Let Us</span>
                            <span class="block text-indigo-600 xl:inline">Assemble</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            CONNECT . JOBS . PEERS . EVENTS
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="h-56 rounded-md getStartedMenuButton inline-block relative">
                                <a href="#" class="getStartedMenuButton w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                    Get started
                                </a>
                                <ul class="getStartedMenu absolute hidden text-gray-700 pt-1">
                                    <li class=""><a onclick="copyToClipboard" class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="auth/signUpStudent.php">as Student</a></li>
                                    <li class=""><a class=" bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="auth/signUpCollege.php">as College</a></li>
                                    <li class=""><a class="rounded-b bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="auth/signUpCompany.php">as Company</a></li>
                                </ul>
                            </div>
                            <style>
                                .getStartedMenuButton:hover .getStartedMenu {
                                    display: block;
                                }
                            </style>
                            <div class="mt-3 sm:mt-0 sm:ml-3 h-56 rounded-md getStartedMenuButton inline-block relative">
                                <a href="#" class="getStartedMenuButton w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10">
                                    Sign In
                                </a>
                                <ul class="getStartedMenu absolute hidden text-gray-700 pt-1">
                                    <li class=""><a onclick="copyToClipboard" class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="auth/signInStudent.php">as Student</a></li>
                                    <li class=""><a class=" bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="auth/signInCollege.php">as College</a></li>
                                    <li class=""><a class="rounded-b bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="auth/signInCompany.php">as Company</a></li>
                                </ul>
                            </div>
                            <style>
                                .getStartedMenuButton:hover .getStartedMenu {
                                    display: block;
                                }
                            </style>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="mt-10 pt-20 mr-20 lg:absolute lg:inset-y-0 lg:right-0 ">
            <img class="h-3/6" src="public/icons/undraw_Work_chat_re_qes4.svg" alt="">
        </div>
        </div>
    <?php
    }
    ?>


    <script>
        $(document).ready(function() {

            $('.submit-edit-slate').click(function() {
                var slateID = $(this).data('id');
                $editSlateSubmitButton = $(this);
                var content = $editSlateSubmitButton.siblings('.contentInEditSlate').children('#contentInEditSlate').val();
                $.ajax({
                    url: 'backend/bookmark.php',
                    type: 'post',
                    data: {
                        'editSlate': 1,
                        'slateID': slateID,
                        'content': content
                    },
                    success: function(res) {
                        console.log(res);
                        location.reload(true);
                        // $replySubmitButton.parent().siblings('.actionBox').children('.replyIconButtons').children('.reply').addClass('hidden');
                        // $replySubmitButton.parent().siblings('.actionBox').children('.replyIconButtons').children('.replyo').trigger('click');
                        // $replySubmitButton.parent().addClass('hidden');
                    }
                });
            });

            $('.submit-edit-reply').click(function() {
                var replyID = $(this).data('id');
                $editReplySubmitButton = $(this);
                var content = $editReplySubmitButton.siblings('.contentInEditReply').children('#contentInEditReply').val();
                $.ajax({
                    url: 'backend/bookmark.php',
                    type: 'post',
                    data: {
                        'editReply': 1,
                        'replyID': replyID,
                        'content': content
                    },
                    success: function(res) {
                        console.log(res);
                        location.reload(true);
                        // $replySubmitButton.parent().siblings('.actionBox').children('.replyIconButtons').children('.reply').addClass('hidden');
                        // $replySubmitButton.parent().siblings('.actionBox').children('.replyIconButtons').children('.replyo').trigger('click');
                        // $replySubmitButton.parent().addClass('hidden');
                    }
                });
            });

            $('.bookmarko').click(function() {
                var slateID = $(this).data('id');
                $post = $(this);
                $.ajax({
                    url: 'backend/bookmark.php',
                    type: 'post',
                    data: {
                        'bookmark': 1,
                        'slateID': slateID
                    },
                    success: function(res) {
                        console.log(res);
                        $post.addClass('hidden');
                        $post.siblings().removeClass('hidden');
                    }
                });
            });

            $('.bookmark').click(function() {
                var slateID = $(this).data('id');
                $post = $(this);
                $.ajax({
                    url: 'backend/bookmark.php',
                    type: 'post',
                    data: {
                        'unbookmark': 1,
                        'slateID': slateID
                    },
                    success: function(res) {
                        $post.addClass('hidden');
                        $post.siblings().removeClass('hidden');
                    }
                });
            });


            $('.submit-slate-reply').click(function() {
                var slateID = $(this).data('id');
                $replySubmitButton = $(this);
                var content = $replySubmitButton.siblings('.replyToSlateInputForm').children('#contentInReplyToSlate').val();
                console.log('clicked');
                $.ajax({
                    url: 'backend/bookmark.php',
                    type: 'post',
                    data: {
                        'replyToSlate': 1,
                        'slateID': slateID,
                        'content': content
                    },
                    success: function(res) {
                        console.log(res);
                        // location.reload(true);
                        // $replySubmitButton.parent().siblings('.actionBox').children('.replyIconButtons').children('.reply').addClass('hidden');
                        // $replySubmitButton.parent().siblings('.actionBox').children('.replyIconButtons').children('.replyo').trigger('click');
                        // $replySubmitButton.parent().addClass('hidden');
                    }
                });
            });


            $('.replyo').click(function() {
                var slateID = $(this).data('id');
                $replySlate = $(this);

                $replySlate.parent().parent().siblings('.replybox').removeClass('hidden');
                $replySlate.siblings().removeClass('hidden');
                $replySlate.addClass('hidden');
            });

            $('.reply').click(function() {
                var slateID = $(this).data('id');
                $replySlate = $(this);

                $replySlate.parent().parent().siblings('.replybox').addClass('hidden');
                $replySlate.siblings().removeClass('hidden');
                $replySlate.addClass('hidden');
            });

            $('.editSlateButton').click(function() {
                $post = $(this);
                $post.parent().parent().parent().parent().siblings('.slateContent').addClass('hidden');
                $post.parent().parent().parent().parent().siblings('.editSlateBox').removeClass('hidden');
            });


            $('.editReplyButton').click(function() {
                console.log('Clicked');
                $post = $(this);
                $post.parent().parent().parent().parent().siblings('.replyContent').addClass('hidden');
                $post.parent().parent().parent().parent().siblings('.editReplyBox').removeClass('hidden');
            })



            // $('.bookmarko').click(function() {
            //     $('.bookmarko').hide();
            // });

        });
    </script>

</body>

</html>