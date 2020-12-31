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
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>cassemble</title>
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
                $creatorType = 'student';
                $creatorQuery = mysqli_query($conn, "SELECT student.name as creatorName, student.imageURL as creatorImage, student.streamYear, college.name as collegeName, stream.acronym, city.name as cityName FROM student, college, stream, city WHERE student.studentID = " . $slatesArr['studentID'] . " AND college.collegeID = student.collegeID AND stream.streamID = student.streamID AND college.cityID = city.cityID");
            }

            if ($slatesArr['collegeID'] !== NULL && $slatesArr['collegeID'] !== '') {
                $creatorType = 'college';
                $creatorQuery = mysqli_query($conn, "SELECT college.name as creatorName, college.logoURL as creatorImage, city.name as cityName, state.name as stateName FROM college, city, state WHERE college.collegeID = " . $slatesArr['collegeID'] . " AND college.cityID = city.cityID AND college.stateID = state.stateID");
            }

            if ($slatesArr['companyID'] !== NULL && $slatesArr['companyID'] !== '') {
                $creatorType = 'company';
                $creatorQuery = mysqli_query($conn, "SELECT company.name as creatorName, company.logoURL as creatorImage, company.headquarters as headquarters FROM company WHERE company.companyID = " . $slatesArr['companyID'] . ";");
            }

            while ($creatorArr = mysqli_fetch_array($creatorQuery)) {
        ?>
                <div class="max-w-xl my-5 mx-auto px-4 py-4 bg-white shadow-md rounded-lg">
                    <div class="flex flex-row items-center">
                        <img class="rounded-full h-10 w-10" src="<?= $creatorArr['creatorImage'] ?>" />
                        <div class="ml-5">
                            <p class=" text-black font-bold"><?= $creatorArr['creatorName'] ?></p>
                            <?php
                            if ($creatorType == 'student') { ?>
                                <p class=" text-black font-light text-xs"><?= $creatorArr['acronym'] ?> . <?= $creatorArr['streamYear'] ?> . <?= $creatorArr['collegeName'] ?> . <?= $creatorArr['cityName'] ?></p>
                            <?php } else if ($creatorType == 'college') { ?>
                                <p class=" text-black font-light text-xs"> <?= $creatorArr['cityName'] ?> . <?= $creatorArr['stateName'] ?></p>
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
                        <div class="ml-auto">
                            <p class="mb-5 text-black font-light text-xs"><?= $slateTime ?></p>
                        </div>
                    </div>
                    <div class="my-5 mx-5 font-normal text-justify"><?= $slatesArr['content'] ?></div>
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
                                $replierType = 'student';
                                $replierQuery = mysqli_query($conn, "SELECT student.name as creatorName, student.imageURL as creatorImage, student.streamYear, college.name as collegeName, stream.acronym, city.name as cityName FROM student, college, stream, city WHERE student.studentID = " . $repliesArr['studentID'] . " AND college.collegeID = student.collegeID AND stream.streamID = student.streamID AND college.cityID = city.cityID");
                            }

                            if ($repliesArr['collegeID'] !== NULL && $repliesArr['collegeID'] !== '') {
                                $replierType = 'college';
                                $replierQuery = mysqli_query($conn, "SELECT college.name as creatorName, college.logoURL as creatorImage, city.name as cityName, state.name as stateName FROM college, city, state WHERE college.collegeID = " . $repliesArr['collegeID'] . " AND college.cityID = city.cityID AND college.stateID = state.stateID");
                            }

                            if ($repliesArr['companyID'] !== NULL && $repliesArr['companyID'] !== '') {
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
                                    </div>
                                    <div class="mt-2 mx-10 px-3 font-normal text-justify"><?= $repliesArr['content'] ?></div>
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
    } else { ?>

        <h5>Not Signed In</h5>
        <h3>Get Started As:</h3>
        <button><a href="auth/signUpStudent.php">Student</a></button>
        <button><a href="auth/signUpCollege.php">College</a></button>
        <button><a href="auth/signUpCompany.php">Company</a></button>
        <br><br><br>
        <h3>Sign In As:</h3>
        <button><a href="auth/signInStudent.php">Student</a></button>
        <button><a href="auth/signInCollege.php">College</a></button>
        <button><a href="auth/signInCompany.php">Company</a></button>
    <?php
    }
    ?>


    <script>
        $(document).ready(function() {

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
                        location.reload(true);
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



            // $('.bookmarko').click(function() {
            //     $('.bookmarko').hide();
            // });

        });
    </script>

</body>

</html>