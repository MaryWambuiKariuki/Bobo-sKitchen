<?php

session_start();

require_once "../db.php";


/*
|--------------------------------------------------------------------------
| Make sure the employee is logged in
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {

    header("Location: ../../login.html");
    exit();

}


/*
|--------------------------------------------------------------------------
| Make sure the logged-in user is an employee
|--------------------------------------------------------------------------
*/

if ($_SESSION["role"] !== "employee") {

    header("Location: ../../login.html");
    exit();

}


$user_id = $_SESSION["user_id"];

$action = $_POST["action"] ?? "";


/*
|--------------------------------------------------------------------------
| CHECK IN
|--------------------------------------------------------------------------
*/

if ($action === "check_in") {

    /*
    Check whether the employee already has an
    attendance record without checking out.
    */

    $sql = "SELECT attendance_id
            FROM attendance
            WHERE user_id = ?
            AND check_out IS NULL
            ORDER BY attendance_id DESC
            LIMIT 1";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $user_id);

    $stmt->execute();

    $result = $stmt->get_result();


    if ($result->num_rows > 0) {

        echo "<h2>You are already checked in.</h2>";

        echo '<p><a href="employee.php">Back to Dashboard</a></p>';

        exit();

    }


    /*
    Record the check-in time
    */

    $sql = "INSERT INTO attendance (user_id, check_in)
            VALUES (?, NOW())";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {

        echo "<h2>Check In Successful!</h2>";

        echo "<p>Your check-in time has been recorded.</p>";

        echo '<p><a href="employee.php">Return to Dashboard</a></p>';

    } else {

        echo "<h2>Check In Failed</h2>";

        echo "<p>Something went wrong. Please try again.</p>";

    }

    exit();

}


/*
|--------------------------------------------------------------------------
| CHECK OUT
|--------------------------------------------------------------------------
*/

if ($action === "check_out") {

    /*
    Find the employee's current open attendance record
    */

    $sql = "SELECT attendance_id
            FROM attendance
            WHERE user_id = ?
            AND check_out IS NULL
            ORDER BY attendance_id DESC
            LIMIT 1";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $user_id);

    $stmt->execute();

    $result = $stmt->get_result();


    if ($result->num_rows === 0) {

        echo "<h2>You are not currently checked in.</h2>";

        echo '<p><a href="employee.php">Back to Dashboard</a></p>';

        exit();

    }


    $attendance = $result->fetch_assoc();

    $attendance_id = $attendance["attendance_id"];


    /*
    Record the check-out time
    */

    $sql = "UPDATE attendance
            SET check_out = NOW()
            WHERE attendance_id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $attendance_id);


    if ($stmt->execute()) {

        echo "<h2>Check Out Successful!</h2>";

        echo "<p>Your check-out time has been recorded.</p>";

        echo '<p><a href="employee.php">Return to Dashboard</a></p>';

    } else {

        echo "<h2>Check Out Failed</h2>";

        echo "<p>Something went wrong. Please try again.</p>";

    }

    exit();

}


/*
|--------------------------------------------------------------------------
| Invalid action
|--------------------------------------------------------------------------
*/

echo "<h2>Invalid Request</h2>";

echo '<p><a href="employee.php">Return to Dashboard</a></p>';

?>