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
| Only admin can delete users
|--------------------------------------------------------------------------
*/

if ($_SESSION["role"] !== "admin") {

    header("Location: ../login.html");

    exit();

}


/*
|--------------------------------------------------------------------------
| Get selected user
|--------------------------------------------------------------------------
*/

$user_id = $_POST["user_id"] ?? "";


if (empty($user_id)) {

    die("Invalid user.");

}


/*
|--------------------------------------------------------------------------
| Prevent admin from deleting themselves
|--------------------------------------------------------------------------
*/

if ($user_id == $_SESSION["user_id"]) {

    die("You cannot delete your own admin account.");

}


/*
|--------------------------------------------------------------------------
| Check user exists
|--------------------------------------------------------------------------
*/

$check = $conn->prepare(
    "SELECT user_id, role
     FROM users
     WHERE user_id = ?"
);

$check->bind_param(
    "i",
    $user_id
);

$check->execute();

$result = $check->get_result();


if ($result->num_rows === 0) {

    die("User not found.");

}


$user = $result->fetch_assoc();


/*
|--------------------------------------------------------------------------
| Prevent deletion of another admin
|--------------------------------------------------------------------------
*/

if ($user["role"] === "admin") {

    die("Admin accounts cannot be deleted here.");

}


/*
|--------------------------------------------------------------------------
| Delete attendance records
|--------------------------------------------------------------------------
*/

$attendance = $conn->prepare(
    "DELETE FROM attendance
     WHERE user_id = ?"
);

$attendance->bind_param(
    "i",
    $user_id
);

$attendance->execute();

$attendance->close();


/*
|--------------------------------------------------------------------------
| Delete user
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "DELETE FROM users
     WHERE user_id = ?"
);

$stmt->bind_param(
    "i",
    $user_id
);


if ($stmt->execute()) {

    header(
        "Location: Dashboard/admin.php"
    );

    exit();

}


echo "Unable to delete user.";


$stmt->close();
$check->close();
$conn->close();

?>