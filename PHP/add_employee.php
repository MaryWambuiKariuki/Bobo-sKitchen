<?php

session_start();

require_once "db.php";


/*
|--------------------------------------------------------------------------
| Make sure user is logged in
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {

    header("Location: ../login.html");

    exit();

}


/*
|--------------------------------------------------------------------------
| Only employers can add employees
|--------------------------------------------------------------------------
*/

if ($_SESSION["role"] !== "employer") {

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


/*
|--------------------------------------------------------------------------
| Validate input
|--------------------------------------------------------------------------
*/

if (empty($username) || empty($password)) {

    die("Username and password are required.");

}


/*
|--------------------------------------------------------------------------
| Check whether username already exists
|--------------------------------------------------------------------------
*/

$check = $conn->prepare(
    "SELECT user_id
     FROM users
     WHERE username = ?"
);

$check->bind_param(
    "s",
    $username
);

$check->execute();

$result = $check->get_result();


if ($result->num_rows > 0) {

    die("That username already exists.");

}


/*
|--------------------------------------------------------------------------
| Hash password
|--------------------------------------------------------------------------
*/

$hashed_password = password_hash(
    $password,
    PASSWORD_DEFAULT
);


/*
|--------------------------------------------------------------------------
| Create employee
|--------------------------------------------------------------------------
*/

$sql = "INSERT INTO users
        (
            username,
            password,
            role
        )
        VALUES
        (
            ?,
            ?,
            'employee'
        )";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ss",
    $username,
    $hashed_password
);


/*
|--------------------------------------------------------------------------
| Save employee
|--------------------------------------------------------------------------
*/

if ($stmt->execute()) {

    header(
        "Location: Dashboard/employer.php"
    );

    exit();

}


echo "Unable to add employee.";


$stmt->close();
$check->close();
$conn->close();

?>