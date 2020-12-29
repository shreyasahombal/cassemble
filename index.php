<?php
require 'backend/db.php';
session_start();
$studentID = $collegeID = $companyID = $id = 0;
$userType;
if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) {
    if ($_SESSION['userType'] === 'student') {
        $studentID = $_SESSION['userID'];
    } else if ($_SESSION['userType'] === 'college') {
        $collegeID = $_SESSION['userID'];
    } else if ($_SESSION['userType'] === 'company') {
        $companyID = $_SESSION['userID'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="public/build/tailwind.css" type="text/css" rel="stylesheet" />
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

        <div class="max-w-xl mx-auto px-4 py-4 bg-white shadow-md rounded-lg">
            <div class="uppercase text-l font-bold text-center">
                Create a Slate
            </div>
            <form action="backend/addSlate.bkd.php" method="POST">
                <input type="hidden" name="studentID" value="<?php echo htmlspecialchars($studentID); ?>">
                <input type="hidden" name="collegeID" value="<?php echo htmlspecialchars($collegeID); ?>">
                <input type="hidden" name="companyID" value="<?php echo htmlspecialchars($companyID); ?>">
                <div class="border-gray-900 mr-20">
                    <textarea class="bg-gray-100" name="content" id="content" cols="73" rows="3"></textarea>
                </div>
                <button type="submit" name="submit-slate" class="w-full font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">Done</button>
            </form>
        </div>
        <?php
        $slatesQuery = mysqli_query($conn, "SELECT * FROM slate");

        while ($slatesArr = mysqli_fetch_array($slatesQuery)) {
            $studentID = $slatesArr['studentID'];
            $collegeID = $slatesArr['collegeID'];
            $companyID = $slatesArr['companyID'];
            $content = $slatesArr['content'];
            if ($studentID !== NULL && $studentID !== '') {
                $studentQuery = mysqli_query($conn, "SELECT student.name as studentName, student.streamYear, college.name as collegeName, stream.acronym, city.name as cityName FROM student, college, stream, city WHERE student.studentID = $studentID AND college.collegeID = student.collegeID AND stream.streamID = student.streamID AND college.cityID = city.cityID");

                while ($studentArr = mysqli_fetch_array($studentQuery)) {
                    echo $studentArr['studentName'];
        ?>

                    <div class="max-w-xl mx-auto px-4 py-4 bg-white shadow-md rounded-lg">
                        <div class="flex flex-row items-center">
                            <img class="rounded-full h-10 w-10" src="https://images.unsplash.com/photo-1520065786657-b71a007dd8a5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=80" />
                            <div class="ml-5">
                                <p class=" text-black font-bold"><?= $studentArr['studentName'] ?></p>
                                <p class=" text-black font-normal text-xs"><?= $studentArr['acronym'] ?> . <?= $studentArr['streamYear'] ?> . <?= $studentArr['collegeName'] ?> . <?= $studentArr['cityName'] ?></p>
                            </div>
                            <div class="ml-auto">
                                <p class="mb-5 text-black font-light text-xs">2h</p>
                            </div>
                        </div>
                        <div class="my-5 mx-5 font-medium"><?= $content ?></div>
                    </div>
        <?php
                }
            }
        }

        ?>
    <?php } else {
    ?>
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

</body>

</html>