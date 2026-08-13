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
| Only employers can delete employees
|--------------------------------------------------------------------------
*/

if ($_SESSION["role"] !== "employer") {

    header("Location: ../login.html");

    exit();

}


/*
|--------------------------------------------------------------------------
| Get employee ID
|--------------------------------------------------------------------------
*/

$user_id = $_POST["user_id"] ?? "";


if (empty($user_id)) {

    die("Invalid employee.");

}


/*
|--------------------------------------------------------------------------
| Make sure the selected user is actually an employee
|--------------------------------------------------------------------------
*/

$check = $conn->prepare(
    "SELECT user_id
     FROM users
     WHERE user_id = ?
     AND role = 'employee'"
);

$check->bind_param(
    "i",
    $user_id
);

$check->execute();

$result = $check->get_result();


if ($result->num_rows === 0) {

    die("Employee not found.");

}


/*
|--------------------------------------------------------------------------
| Delete attendance records first
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
| Delete employee
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "DELETE FROM users
     WHERE user_id = ?
     AND role = 'employee'"
);

$stmt->bind_param(
    "i",
    $user_id
);


if ($stmt->execute()) {

    header(
        "Location: Dashboard/employer.php"
    );

    exit();

}


echo "Unable to delete employee.";


$stmt->close();
$check->close();
$conn->close();

?>