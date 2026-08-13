<?php

session_start();

require_once "../db.php";


/*
|--------------------------------------------------------------------------
| Make sure employee is logged in
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {

    header("Location: ../../login.html");

    exit();

}


/*
|--------------------------------------------------------------------------
| Make sure user is an employee
|--------------------------------------------------------------------------
*/

if ($_SESSION["role"] !== "employee") {

    header("Location: ../../login.html");

    exit();

}


/*
|--------------------------------------------------------------------------
| Get submitted information
|--------------------------------------------------------------------------
*/

$order_id = $_POST["order_id"] ?? "";

$status = $_POST["status"] ?? "";


/*
|--------------------------------------------------------------------------
| Validate
|--------------------------------------------------------------------------
*/

if (empty($order_id) || empty($status)) {

    die("Invalid order information.");

}


/*
|--------------------------------------------------------------------------
| Only allow the status we currently need
|--------------------------------------------------------------------------
*/

if ($status !== "Ready") {

    die("Invalid order status.");

}


/*
|--------------------------------------------------------------------------
| Update order
|--------------------------------------------------------------------------
*/

$sql = "UPDATE orders
        SET status = ?
        WHERE order_id = ?";


$stmt = $conn->prepare($sql);


if (!$stmt) {

    die(
        "SQL Error: " .
        $conn->error
    );

}


$stmt->bind_param(
    "si",
    $status,
    $order_id
);


if ($stmt->execute()) {

    header(
        "Location: employee.php"
    );

    exit();

} else {

    echo "

        <h2>Unable to update order</h2>

        <p>
            Something went wrong.
        </p>

        <a href='employee.php'>
            Return to Employee Dashboard
        </a>

    ";

}


$stmt->close();

$conn->close();

?>