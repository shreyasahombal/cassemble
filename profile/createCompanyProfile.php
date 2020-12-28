<?php
require '../backend/db.php';
session_start();
$emailID = $_SESSION['userEmailID'];
$sql = "SELECT companyID FROM company WHERE emailID=?";
$stmt = mysqli_stmt_init($conn); //initialized the connection
if (!mysqli_stmt_prepare($stmt, $sql)) { //checking if connection is perfect
    header("Location: ../profile/createCollegeProfile.php?error=sqlerrorinpage");
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "s", $emailID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $companyID = $row['companyID'];
    } else {
        header("Location: ../auth/signUpCompany.php?error=companynotfound");
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
            <form class="submit-create-company-profile mt-6" action="../backend/createProfile.bkd.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="companyID" value="<?php echo htmlspecialchars($companyID); ?>"/>
                <label for="name" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">FULL NAME</label>
                <input id="name" type="text" name="name" placeholder="Some Company" autocomplete="name" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                <label for="headquarters" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">headquarters</label>
                <input id="headquarters" type="text" name="headquarters" placeholder="Bengaluru" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                <label for="description" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">description</label>
                <input id="description" type="text" name="description" placeholder="About the Company. In Short" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                <label for="websiteURL" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Website URL</label>
                <input id="websiteURL" type="url" name="websiteURL" placeholder="somecollege.edu.in" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                <label for="logoURL" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Logo URL</label>
             <input id="logoURL" type="url" name="logoURL" placeholder="somecollege.edu.in" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                <button type="submit" name="submit-create-company-profile" class="w-full py-3 mt-6 font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">
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