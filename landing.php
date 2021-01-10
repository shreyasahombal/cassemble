<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/landing-styles.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="bootstrap.js"></script>
    
    <title>cassemble</title>
  </head>
  <body>

    <section class="background firstsection">
      <div class="box-main">
        <div class="firsthalf">
          <p class="text">Welcome to cassemble!</p>
        </div>
        <div class="sign">
          <div class="dropdown">
          <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
          Sign In As
          </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <li><a class="dropdown-item" href="auth/signUpStudent.php">Student</a></li>
              <li><a class="dropdown-item" href="auth/signUpCollege.php">College</a></li>
              <li><a class="dropdown-item" href="auth/signUpCompany.php">Company</a></li>
            </ul>
          </div>
          <div class="dropdown">
          <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
          Sign Up As
          </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <li><a class="dropdown-item" href="auth/signUpStudent.php">Student</a></li>
              <li><a class="dropdown-item" href="auth/signUpCollege.php">College</a></li>
              <li><a class="dropdown-item" href="auth/signUpCompany.php">Company</a></li>
            </ul>
          </div>
          
      </div>    
      </div>
      
    </section>
    
    <!-- Footer -->
<footer class="page-footer font-small black">

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2020 Copyright:
    
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  </body>
</html>
