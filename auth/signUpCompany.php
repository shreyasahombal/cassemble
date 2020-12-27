<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/build/tailwind.css">
    <title>Sign Up Company</title>
</head>

<body>

    <?php
    if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) {
        header('Location: ../index.php');
    } else {
    ?>
        <div class="grid min-h-screen place-items-center">
            <div class="w-11/12 p-12 bg-white sm:w-8/12 md:w-1/2 lg:w-5/12">
                <h1 class="text-l text-center font-light">cassemble.company</h1>
                <br><br>
                <h1 class="text-center text-9xl font-black">Sign Up</h1>
                <br><br>
                <form class="submit-signup-company mt-6" action="../backend/signup.bkd.php" method="POST">
                    <label for="emailID" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">E-mail</label>
                    <input id="emailID" type="email" name="emailID" placeholder="some.company@some-domain.com" autocomplete="email" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                    <label for="password" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Password</label>
                    <input id="password" type="password" name="password" placeholder="********" autocomplete="new-password" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                    <label for="confirmpassword" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Confirm password</label>
                    <input id="confirmpassword" type="password" name="confirmpassword" placeholder="********" autocomplete="new-password" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner" required />
                    <button type="submit" name="submit-signup-company" class="submit-signup-company w-full py-3 mt-6 font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">
                        Sign up
                    </button>
                    <p class="flex justify-between inline-block mt-4 text-xs text-gray-500 cursor-pointer hover:text-black">Sign In?</p>
                </form>
            </div>
        </div>
    <?php
    }
    ?>
</body>

</html>