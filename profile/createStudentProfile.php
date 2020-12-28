<?php
require '../backend/db.php';
session_start();
$emailID = $_SESSION['userEmailID'];
$sql = "SELECT studentID FROM student WHERE emailID=?";
$stmt = mysqli_stmt_init($conn); //initialized the connection
if (!mysqli_stmt_prepare($stmt, $sql)) { //checking if connection is perfect
    header("Location: ../profile/createStudentProfile.php?error=sqlerrorinpage");
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "s", $emailID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $studentID = $row['studentID'];
    } else {
        header("Location: ../auth/signUpStudent.php?error=studentnotfound");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Template</title>
    <link rel="stylesheet" href="../public/build/tailwind.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet" />
</head>

<body>
    <div class="grid min-h-screen place-items-center">
        <div class="w-11/12 p-12 bg-white sm:w-8/12 md:w-1/2 lg:w-5/12">
            <h1 class="text-l text-center font-bold">cassemble.student</h1>
            <br><br>
            <h1 class="text-center text-5xl font-black">Who Am I</h1>
            <br><br>
            <form class="submit-create-student-profile mt-6" action="../backend/createProfile.bkd.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="studentID" value="<?php echo htmlspecialchars($studentID); ?>">
                <label for="name" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">FULL NAME</label>
                <input id="name" type="text" name="name" placeholder="My Full Name" autocomplete="name" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                <label for="collegeID" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">college</label>
                <select class="collegeID block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" name="collegeID" id="collegeID" required>
                    <option value="NULL">Select College</option>
                    <?php
                    $collegeQuery = mysqli_query($conn, "SELECT collegeID, name FROM college");

                    while ($collegeArr = mysqli_fetch_array($collegeQuery)) {
                        echo '<option value="' . $collegeArr['collegeID'] . '">' . $collegeArr['name'] . '</option>';
                    }
                    ?>
                </select>
                <label for="streamID" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">stream</label>
                <select class="streamID block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" name="streamID" id="streamID" required>
                    <option value="NULL">Select Stream</option>
                    <?php
                    $streamQuery = mysqli_query($conn, "SELECT streamID, name FROM stream");
                    while ($streamArr = mysqli_fetch_array($streamQuery)) {
                        echo '<option value="' . $streamArr['streamID'] . '">' . $streamArr['name'] . '</option>';
                    }
                    ?>
                </select>
                <label for="streamYear" class="block mt-2 text-xs font-semibold text-gray-600 uppercase"> Stream Study Year</label>
                <select class="streamYear block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" name="streamYear" id="streamYear" required>
                    <option value="NULL">Current Course Year</option>
                    <option value="1st">1st Year</option>
                    <option value="2nd">2nd Year</option>
                    <option value="3rd">3rd Year</option>
                    <option value="4th">4th Year</option>
                    <option value="ALUMNI">Alumni</option>
                </select>
                </label>
                <label for="skills" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">skills</label>
                <select class="chosen-select skills[] block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" name="skills[]" id="skills[]" data-placeholder="Start typing and Select Many" multiple required>
                    <option value="NULL"></option>
                    <?php
                    $skillsQuery = mysqli_query($conn, "SELECT skillID, name FROM skill");

                    while ($skillsArr = mysqli_fetch_array($skillsQuery)) {
                        echo '<option value="' . $skillsArr['skillID'] . '">' . $skillsArr['name'] . '</option>';
                    }

                    mysqli_close($conn);
                    ?>
                </select>
                <label for="websiteURL" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Website URL</label>
                <input id="websiteURL" type="url" name="websiteURL" placeholder="www.my-name.dev" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" />
                <label for="imageURL" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Profile Image URL</label>
                <input id="imageURL" type="url" name="imageURL" placeholder="http://" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                <label for="resumeURL" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Resume URL</label>
                <input id="resumeURL" type="url" name="resumeURL" placeholder="http://" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" />
                <button type="submit" name="submit-create-student-profile" class="w-full py-3 mt-6 font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">
                    Done
                </button>
                <p class="flex justify-between inline-block mt-4 text-xs text-gray-500 cursor-pointer hover:text-black">Sign Out?</p>
        </div>
    </div>
    <script>
        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        })
    </script>
</body>

</html>