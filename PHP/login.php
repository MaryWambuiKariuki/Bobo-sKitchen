<?php

session_start();

require_once "db.php";


/*
|--------------------------------------------------------------------------
| Check if the form was submitted
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../login.html");
    exit();

}


/*
|--------------------------------------------------------------------------
| Get form information
|--------------------------------------------------------------------------
*/

$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";
$role = $_POST["role"] ?? "";


/*
|--------------------------------------------------------------------------
| Make sure all fields were completed
|--------------------------------------------------------------------------
*/

if (empty($username) || empty($password) || empty($role)) {

    die("Please complete all login fields.");

}


/*
|--------------------------------------------------------------------------
| Find the user
|--------------------------------------------------------------------------
*/

$sql = "SELECT * FROM users WHERE username = ? AND role = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("ss", $username, $role);

$stmt->execute();

$result = $stmt->get_result();


/*
|--------------------------------------------------------------------------
| Check if user exists
|--------------------------------------------------------------------------
*/

if ($result->num_rows === 1) {

    $user = $result->fetch_assoc();


    /*
    |--------------------------------------------------------------------------
    | Verify password
    |--------------------------------------------------------------------------
    */

    if (password_verify($password, $user["password"])) {


        /*
        |--------------------------------------------------------------------------
        | Login successful
        |--------------------------------------------------------------------------
        */

        $_SESSION["user_id"] = $user["user_id"];

        $_SESSION["full_name"] = $user["full_name"];

        $_SESSION["username"] = $user["username"];

        $_SESSION["role"] = $user["role"];


        /*
        |--------------------------------------------------------------------------
        | Redirect according to role
        |--------------------------------------------------------------------------
        */

        if ($user["role"] === "employee") {

            header("Location: dashboard/employee.php");
            exit();

        }

        elseif ($user["role"] === "employer") {

            header("Location: dashboard/employer.php");
            exit();

        }

        elseif ($user["role"] === "admin") {

            header("Location: dashboard/admin.php");
            exit();

        }

    }

}


/*
|--------------------------------------------------------------------------
| Login failed
|--------------------------------------------------------------------------
*/

echo "<h2>Login Failed</h2>";

echo "<p>Incorrect username, password or role.</p>";

echo '<p><a href="../login.html">Try Again</a></p>';

?>