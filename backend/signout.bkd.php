<?php
require 'db.php';
session_start();

session_unset();
session_destroy();
header("Location: ../index.php?signout=success");
exit();