<?php

require_once "db.php";


/* =====================================================
   CHECK REQUEST
   ===================================================== */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    die("Invalid request.");

}


/* =====================================================
   GET FORM DATA
   ===================================================== */

$customer_name = trim($_POST["customer_name"] ?? "");

$food_item = trim($_POST["food_item"] ?? "");

$review = trim($_POST["review"] ?? "");


/* =====================================================
   VALIDATE DATA
   ===================================================== */

if (
    empty($customer_name) ||
    empty($food_item) ||
    empty($review)
) {

    die("Please fill in all required fields.");

}


/* =====================================================
   SAVE REVIEW
   ===================================================== */

$sql = "
    INSERT INTO reviews
    (
        customer_name,
        food_item,
        review
    )
    VALUES (?, ?, ?)
";


$stmt = $conn->prepare($sql);


if (!$stmt) {

    die(
        "Prepare failed: " .
        $conn->error
    );

}


$stmt->bind_param(
    "sss",
    $customer_name,
    $food_item,
    $review
);


if ($stmt->execute()) {

    /*
       Redirect back to order page
       after successful submission.
    */

    header(
        "Location: ../order.html?review=success"
    );

    exit;

}


die(
    "Unable to save review: " .
    $stmt->error
);

?>