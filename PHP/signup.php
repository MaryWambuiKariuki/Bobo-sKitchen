<?php

session_start();


if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../signup.html");

    exit();

}


$fullName =
    trim($_POST["fullName"] ?? "");


$username =
    trim($_POST["username"] ?? "");


$password =
    $_POST["password"] ?? "";


$confirmPassword =
    $_POST["confirmPassword"] ?? "";


$role =
    $_POST["role"] ?? "";


/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

if (
    empty($fullName) ||
    empty($username) ||
    empty($password) ||
    empty($confirmPassword) ||
    empty($role)
) {

    header(
        "Location: ../signup.html?error=required"
    );

    exit();

}


if ($password !== $confirmPassword) {

    header(
        "Location: ../signup.html?error=password"
    );

    exit();

}


/*
|--------------------------------------------------------------------------
| DATABASE REGISTRATION WILL GO HERE
|--------------------------------------------------------------------------
|
| Later we will:
|
| 1. Connect to MySQL
| 2. Check whether username exists
| 3. Hash the password
| 4. Insert the user
| 5. Redirect to login
|
*/


echo "<h2>Sign Up Form Received</h2>";

echo "<p>";

echo "Welcome, " .
     htmlspecialchars($fullName) .
     ".";

echo "</p>";

echo "<p>";

echo "Database registration will be connected next.";

echo "</p>";

?>