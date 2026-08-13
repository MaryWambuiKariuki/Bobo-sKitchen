<?php

require_once "db.php";


/*
|--------------------------------------------------------------------------
| Get review information
|--------------------------------------------------------------------------
*/

$customer_name = trim(
    $_POST["customer_name"] ?? ""
);

$food_item = trim(
    $_POST["food_item"] ?? ""
);

$review = trim(
    $_POST["review"] ?? ""
);


/*
|--------------------------------------------------------------------------
| Validate fields
|--------------------------------------------------------------------------
*/

if (
    empty($customer_name) ||
    empty($food_item) ||
    empty($review)
) {

    die("Please complete all review fields.");

}


/*
|--------------------------------------------------------------------------
| Save review
|--------------------------------------------------------------------------
*/

$sql = "
    INSERT INTO reviews
    (
        customer_name,
        food_item,
        review
    )
    VALUES
    (
        ?,
        ?,
        ?
    )
";


$stmt = $conn->prepare($sql);


$stmt->bind_param(
    "sss",
    $customer_name,
    $food_item,
    $review
);


/*
|--------------------------------------------------------------------------
| Execute
|--------------------------------------------------------------------------
*/

if ($stmt->execute()) {

    header(
        "Location: ../order.html?review=success"
    );

    exit();

}


echo "Unable to save your review.";


$stmt->close();
$conn->close();

?>