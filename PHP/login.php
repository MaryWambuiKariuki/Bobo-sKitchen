<?php

session_start();

/*
|--------------------------------------------------------------------------
| Login Handler
|--------------------------------------------------------------------------
|
| Database authentication will be implemented when
| MySQL is added.
|
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../login.html");

    exit();

}


$username =
    trim($_POST["username"] ?? "");

$password =
    $_POST["password"] ?? "";

$role =
    $_POST["role"] ?? "";


/*
|--------------------------------------------------------------------------
| Basic validation
|--------------------------------------------------------------------------
*/

if (
    empty($username) ||
    empty($password) ||
    empty($role)
) {

    header(
        "Location: ../login.html?error=required"
    );

    exit();

}


/*
|--------------------------------------------------------------------------
| DATABASE LOGIN WILL GO HERE
|--------------------------------------------------------------------------
|
| Later:
|
| 1. Connect to MySQL
| 2. Find the user
| 3. Verify the password
| 4. Verify the role
| 5. Create the session
| 6. Redirect to the correct dashboard
|
*/


/*
|--------------------------------------------------------------------------
| Temporary message
|--------------------------------------------------------------------------
*/

echo "<h2>PHP Login System</h2>";

echo "<p>";

echo "The login form was successfully received.";

echo "</p>";

echo "<p>";

echo "MySQL authentication will be connected next.";

echo "</p>";

?>