<?php

require_once "db.php";


/*
|--------------------------------------------------------------------------
| Get food item
|--------------------------------------------------------------------------
*/

$food_item = trim(
    $_GET["food_item"] ?? ""
);


if (empty($food_item)) {

    echo json_encode([]);

    exit();

}


/*
|--------------------------------------------------------------------------
| Get reviews
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT
        customer_name,
        review,
        review_date

    FROM reviews

    WHERE food_item = ?

    ORDER BY review_date DESC
";


$stmt = $conn->prepare($sql);


$stmt->bind_param(
    "s",
    $food_item
);


$stmt->execute();


$result = $stmt->get_result();


$reviews = [];


while (
    $row = $result->fetch_assoc()
) {

    $reviews[] = $row;

}


/*
|--------------------------------------------------------------------------
| Return JSON
|--------------------------------------------------------------------------
*/

header(
    "Content-Type: application/json"
);


echo json_encode($reviews);


$stmt->close();
$conn->close();

?>