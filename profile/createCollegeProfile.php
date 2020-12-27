<?php
require '../backend/db.php';
session_start();
$emailID = $_SESSION['userEmailID'];
$sql = "SELECT collegeID FROM college WHERE emailID=?";
$stmt = mysqli_stmt_init($conn); //initialized the connection
if (!mysqli_stmt_prepare($stmt, $sql)) { //checking if connection is perfect
    header("Location: ../profile/createCollegeProfile.php?error=sqlerrorinpage");
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "s", $emailID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $collegeID = $row['collegeID'];
    } else {
        header("Location: ../auth/signUpCollege.php?error=collegenotfound");
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
            <h1 class="text-l text-center font-bold">cassemble.college</h1>
            <br><br>
            <h1 class="text-center text-5xl font-black">College Info</h1>
            <br><br>
            <form class="submit-create-college-profile mt-6" action="../backend/createProfile.bkd.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="collegeID" value="<?php echo htmlspecialchars($collegeID); ?>"/>
                <label for="name" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">FULL NAME</label>
                <input id="name" type="text" name="name" placeholder="Some Engineering College" autocomplete="name" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                <label for="state" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">city</label>
                <select class="common_selector_class1 state block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" name="state" id="state">
                    <option value="NULL" selected>Select State</option>
                    <?php
                    $stateQuery = mysqli_query($conn, "SELECT stateID, name FROM state");

                    while ($stateArr = mysqli_fetch_array($stateQuery)) {
                        echo '<option value="' . $stateArr['stateID'] . '">' . $stateArr['name'] . '</option>';
                    }
                    ?>
                </select>
                <label for="city" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">city</label>
                <select class="common_selector_class1 city block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" name="city" id="city" required>
                    <option value="NULL" selected>Select City</option>
                    <?php
                    $cityQuery = mysqli_query($conn, "SELECT cityID, name FROM city");

                    while ($cityArr = mysqli_fetch_array($cityQuery)) {
                        echo '<option value="' . $cityArr['cityID'] . '">' . $cityArr['name'] . '</option>';
                    }
                    ?>
                </select>
                <label for="streams" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">streams</label>
                <select class="chosen-select common_selector_class1 streams[] block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" name="streams[]" id="streams[]" data-placeholder="Start typing and Select Many" multiple required>
                    <option value="NULL"></option>
                    <?php
                    $streamsQuery = mysqli_query($conn, "SELECT streamID, name FROM stream");

                    while ($streamsArr = mysqli_fetch_array($streamsQuery)) {
                        echo '<option value="' . $streamsArr['streamID'] . '">' . $streamsArr['name'] . '</option>';
                    }
                    
                    mysqli_close($conn);
                    ?>
                </select>
                <label for="websiteURL" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Website URL</label>
                <input id="websiteURL" type="url" name="websiteURL" placeholder="somecollege.edu.in" autocomplete="new-password" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                <label for="logoURL" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Logo URL</label>
                <input id="logoURL" type="url" name="logoURL" placeholder="somecollege.edu.in" autocomplete="new-password" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                <label for="bannerURL" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Banner URL</label>
                <input id="bannerURL" type="url" name="bannerURL" placeholder="somecollege.edu.in" autocomplete="new-password" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                <button type="submit" name="submit-create-college-profile" class="w-full py-3 mt-6 font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">
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