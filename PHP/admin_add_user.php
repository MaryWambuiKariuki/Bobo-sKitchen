<?php

session_start();

require_once "db.php";


/*
|--------------------------------------------------------------------------
| Check login
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {

    header("Location: ../login.html");

    exit();

}


/*
|--------------------------------------------------------------------------
| Only admin can use this page
|--------------------------------------------------------------------------
*/

if ($_SESSION["role"] !== "admin") {

    header("Location: ../login.html");

    exit();

}


/*
|--------------------------------------------------------------------------
| Get submitted information
|--------------------------------------------------------------------------
*/

$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";
$role = $_POST["role"] ?? "";


/*
|--------------------------------------------------------------------------
| Validate information
|--------------------------------------------------------------------------
*/

if (
    empty($username) ||
    empty($password) ||
    empty($role)
) {

    die("All fields are required.");

}


/*
|--------------------------------------------------------------------------
| Only allow employee or employer
|--------------------------------------------------------------------------
*/

if (
    $role !== "employee" &&
    $role !== "employer"
) {

    die("Invalid role.");

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
| Add user
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "INSERT INTO users
    (
        username,
        password,
        role
    )
    VALUES
    (
        ?,
        ?,
        ?
    )"
);

$stmt->bind_param(
    "sss",
    $username,
    $hashed_password,
    $role
);


/*
|--------------------------------------------------------------------------
| Save
|--------------------------------------------------------------------------
*/

if ($stmt->execute()) {

    header(
        "Location: Dashboard/admin.php"
    );

    exit();

}


echo "Unable to add user.";


$stmt->close();
$check->close();
$conn->close();

?>