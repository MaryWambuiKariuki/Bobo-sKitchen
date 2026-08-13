<?php

session_start();

require_once "db.php";


/*
|--------------------------------------------------------------------------
| Check if user is logged in
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {

    header("Location: ../login.html");

    exit();

}


/*
|--------------------------------------------------------------------------
| Check if user is an employee
|--------------------------------------------------------------------------
*/

if ($_SESSION["role"] !== "employee") {

    header("Location: ../login.html");

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
    | Check if employee has already checked in today.
    |
    | DATE(check_in) extracts the date from the
    | check_in DATETIME value.
    */

    $check = $conn->prepare(
        "SELECT attendance_id
         FROM attendance
         WHERE user_id = ?
         AND DATE(check_in) = CURDATE()"
    );


    $check->bind_param(
        "i",
        $user_id
    );


    $check->execute();


    $result = $check->get_result();


    /*
    | Employee already has an attendance record today
    */

    if ($result->num_rows > 0) {

        echo "

            <h2>Already Checked In</h2>

            <p>
                You have already checked in today.
            </p>

            <a href='Dashboard/employee.php'>
                Return to Employee Dashboard
            </a>

        ";

        exit();

    }


    /*
    |--------------------------------------------------------------------------
    | Create new attendance record
    |--------------------------------------------------------------------------
    */

    $sql = "INSERT INTO attendance
            (
                user_id,
                check_in
            )
            VALUES
            (
                ?,
                NOW()
            )";


    $stmt = $conn->prepare($sql);


    $stmt->bind_param(
        "i",
        $user_id
    );


    if ($stmt->execute()) {

        header(
            "Location: Dashboard/employee.php"
        );

        exit();

    }


    /*
    | If something goes wrong
    */

    echo "

        <h2>Check In Failed</h2>

        <p>
            Unable to record your check in.
        </p>

        <a href='Dashboard/employee.php'>
            Return to Dashboard
        </a>

    ";

}


/*
|--------------------------------------------------------------------------
| CHECK OUT
|--------------------------------------------------------------------------
*/

elseif ($action === "check_out") {


    /*
    |--------------------------------------------------------------------------
    | Find today's active attendance record
    |--------------------------------------------------------------------------
    |
    | check_out IS NULL means the employee has not
    | checked out yet.
    |
    */

    $sql = "UPDATE attendance

            SET check_out = NOW()

            WHERE user_id = ?

            AND DATE(check_in) = CURDATE()

            AND check_out IS NULL";


    $stmt = $conn->prepare($sql);


    $stmt->bind_param(
        "i",
        $user_id
    );


    if ($stmt->execute()) {


        /*
        | Check if an attendance record was updated
        */

        if ($stmt->affected_rows > 0) {

            header(
                "Location: Dashboard/employee.php"
            );

            exit();

        }


        /*
        | No record was updated
        */

        echo "

            <h2>Check Out Unsuccessful</h2>

            <p>
                You either have not checked in today
                or you have already checked out.
            </p>

            <a href='Dashboard/employee.php'>
                Return to Employee Dashboard
            </a>

        ";

    }


}


/*
|--------------------------------------------------------------------------
| Invalid action
|--------------------------------------------------------------------------
*/

else {

    echo "

        <h2>Invalid Request</h2>

        <p>
            Please use the Check In or Check Out button.
        </p>

        <a href='Dashboard/employee.php'>
            Return to Employee Dashboard
        </a>

    ";

}


$conn->close();

?>