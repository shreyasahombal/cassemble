<?php
require 'backend/db.php';
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
    <title>events</title>
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
                <a href="#" class="my-1 text-gray-800 hover:text-blue-500 md:mx-4 md:my-0">jobs</a>
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
    if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) {
        if ($userType == 'college') {
    ?>
            <div class="max-w-xl mx-auto mt-5 px-4 py-4 bg-white shadow-md rounded-lg">
                <div class="uppercase text-l font-bold text-center">
                    Create an Event
                </div>
                <form action="backend/addEvent.bkd.php" method="POST">
                    <input type="hidden" name="collegeID" value="<?php echo htmlspecialchars($collegeID); ?>">
                    <label for="title" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Title</label>
                    <input id="title" type="text" name="title" placeholder="Adbutha 2022" autocomplete="title" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                    <div class="border-gray-900 my-2">

                        <label for="eventDescription" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Event Description</label>
                        <textarea name="eventDescription" placeholder="rbfkdsvnjcrelkcjbbnxrikjcbnrelidsj" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required id="eventDescription" cols="100" rows="3"></textarea>
                    </div>
                    <button type="submit" name="submit-event" class="w-full font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">Create</button>
                </form>
            </div>
            <?php
        }

        $eventsQuery = mysqli_query($conn, "SELECT * FROM events ORDER BY createdAt DESC");

        while ($eventsArr = mysqli_fetch_array($eventsQuery)) {
            $jobID = $eventsArr['jobID'];

            $collegeQuery = mysqli_query($conn, "SELECT college.name, college.logoURL, city.name as cityName, state.name as stateName FROM college, city, state WHERE college.collegeID = '" . $eventsArr['collegeID'] . "' college.cityID = city.cityID college.stateID = state.stateID ;");

            while ($collegeArr = mysqli_fetch_array($collegeQuery)) {
            ?>
                <div class="max-w-xl my-5 mx-auto px-4 py-4 bg-white shadow-md rounded-lg">
                    <div class="flex flex-row items-center">
                        <a href="college.php?collegeID=<?= $eventsArr['collegeID'] ?>" target="_blank"><img class="rounded-full h-10 w-10" src="<?= $collegeArr['logoURL'] ?>" /></a>
                        <div class="ml-5">
                            <a href="college.php?collegeID=<?= $eventsArr['collegeID'] ?>" target="_blank">
                                <p class=" text-black font-bold"><?= $eventsArr['title'] ?></p>
                            </a>
                            <p class=" text-black font-light text-sm"><?= $collegeArr['name'] ?> . <?= $collegeArr['headquarters'] ?></p>
                        </div>
                        <?php
                        $eventPostedTime;
                        date_default_timezone_set('Asia/Kolkata');
                        $time_ago = strtotime($eventsArr['createdAt']);
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
                            $eventPostedTime = "NOW";
                        } else if ($minutes <= 60) {
                            if ($minutes == 1) {
                                $eventPostedTime = "1 min";
                            } else {
                                $eventPostedTime = "$minutes mins";
                            }
                        } else if ($hours <= 24) {
                            if ($hours == 1) {
                                $eventPostedTime = "1 hr";
                            } else {
                                $eventPostedTime = "$hours hrs";
                            }
                        } else if ($days <= 7) {
                            if ($days == 1) {
                                $eventPostedTime = "yesterday";
                            } else {
                                $eventPostedTime = "$days d";
                            }
                        } else if ($weeks <= 4.3) //4.3 == 52/12  
                        {
                            if ($weeks == 1) {
                                $eventPostedTime = "1 w";
                            } else {
                                $eventPostedTime = "$weeks w";
                            }
                        } else if ($months <= 12) {
                            if ($months == 1) {
                                $eventPostedTime = "1 m";
                            } else {
                                $eventPostedTime = "$months m";
                            }
                        } else {
                            if ($years == 1) {
                                $eventPostedTime = "1 y";
                            } else {
                                $eventPostedTime = "$years y";
                            }
                        }
                        ?>
                        <div class="pt-5 mr-2 ml-auto">
                            <p class="mb-5 text-black font-light text-xs"><?= $eventPostedTime ?></p>
                        </div>

                        <div>
                            <div class="slateMenuButton inline-block relative">
                                <img class="w-3 slateMenuButton" src="public/icons/ellipsis.svg" data-id="<?php echo $eventsArr['jobID']; ?>" alt="" srcset="">
                                <ul class="slateMenu absolute hidden text-gray-700 pt-1">
                                    <?php
                                    if ($eventsArr['collegeID'] == $userID) { ?>
                                        <li class=""><a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="#">Share</a></li>
                                        <li class="editSlateButton rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap">Edit</li>
                                        <li class=""><a class="rounded-b bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="backend/deleteSlate.php?jobID=<?php echo $eventsArr['jobID']; ?>">Delete</a></li>
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
                    <div class="jobContent h-56 overflow-auto my-5 mx-5 font-normal text-justify"><?= nl2br($eventsArr['content']) ?></div>
                    <?php
                    if ($userType == 'student') {
                    ?>
                        <div class="flex justify-evenly text-center actionBar">
                            <div class="flex">
                                <?php
                                $bookmarkedQuery = mysqli_query($conn, "SELECT * FROM bookmarks WHERE jobID = '" . $eventsArr['jobID'] . "' AND collegeID = '" . $userID . "' ;");

                                if ($bookmarkedArr = mysqli_fetch_array($bookmarkedQuery)) {
                                ?>
                                    <img class="w-5 bookmark" src="public/icons/bookmark.svg" data-id="<?php echo $eventsArr['jobID']; ?>" alt="" srcset="">
                                    <img class="w-5 bookmarko hidden" src="public/icons/bookmark-o.svg" data-id="<?php echo $eventsArr['jobID']; ?>" alt="" srcset="">
                                <?php
                                } else {
                                ?>
                                    <img class="w-5 bookmarko" src="public/icons/bookmark-o.svg" data-id="<?php echo $eventsArr['jobID']; ?>" alt="" srcset="">
                                    <img class="w-5 bookmark hidden" src="public/icons/bookmark.svg" data-id="<?php echo $eventsArr['jobID']; ?>" alt="" srcset="">
                                <?php
                                }
                                ?>
                            </div>
                            <?php
                            $appliedQuery = mysqli_query($conn, "SELECT * FROM jobandstudent WHERE jobID = '" . $eventsArr['jobID'] . "' AND studentID = '" . $userID . "' ;");

                            if ($appliedArr = mysqli_fetch_array($appliedQuery)) {
                            ?>
                                <button class="applied uppercase shadow bg-gray-400 hover:bg-gray-900 focus:shadow-outline focus:outline-none text-white text-xs px-3 py-2 rounded-3xl" data-id="<?php echo $eventsArr['jobID']; ?>">APPLIED</button>
                                <button class="apply hidden uppercase shadow bg-red-500 hover:bg-green-900 focus:shadow-outline focus:outline-none text-white text-xs px-3 py-2 rounded-3xl" data-id="<?php echo $eventsArr['jobID']; ?>">APPLY</button>
                            <?php
                            } else {
                            ?>
                                <button class="applied hidden uppercase shadow bg-gray-400 hover:bg-gray-900 focus:shadow-outline focus:outline-none text-white text-xs px-3 py-2 rounded-3xl" data-id="<?php echo $eventsArr['jobID']; ?>">APPLIED</button>
                                <button class="apply uppercase shadow bg-red-500 hover:bg-green-900 focus:shadow-outline focus:outline-none text-white text-xs px-3 py-2 rounded-3xl" data-id="<?php echo $eventsArr['jobID']; ?>">APPLY</button>
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
                        'bookmarkJob': 1,
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