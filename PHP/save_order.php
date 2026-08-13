<?php

require_once "db.php";


/*
|--------------------------------------------------------------------------
| Make sure the form was submitted
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../order.html");
    exit();

}


/*
|--------------------------------------------------------------------------
| Get customer information
|--------------------------------------------------------------------------
*/

$customer_name = trim($_POST["customer_name"] ?? "");

$table_number = $_POST["table_number"] ?? "";

$food_item = trim($_POST["food_item"] ?? "");

$quantity = $_POST["quantity"] ?? "";

$special_instructions = trim(
    $_POST["special_instructions"] ?? ""
);


/*
|--------------------------------------------------------------------------
| Validate required fields
|--------------------------------------------------------------------------
*/

if (
    empty($customer_name) ||
    empty($table_number) ||
    empty($food_item) ||
    empty($quantity)
) {

    die("
        <h2>Order Not Submitted</h2>
        <p>Please complete all required fields.</p>
        <a href='../order.html'>Return to Order Page</a>
    ");

}


/*
|--------------------------------------------------------------------------
| Insert order into database
|--------------------------------------------------------------------------
*/

$status = "Pending";

$sql = "INSERT INTO orders
        (
            customer_name,
            table_number,
            food_item,
            quantity,
            special_instructions,
            status
        )
        VALUES (?, ?, ?, ?, ?, ?)";


$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "sisiss",
    $customer_name,
    $table_number,
    $food_item,
    $quantity,
    $special_instructions,
    $status
);


/*
|--------------------------------------------------------------------------
| Save order
|--------------------------------------------------------------------------
*/

if ($stmt->execute()) {

    echo "

        <!DOCTYPE html>

        <html>

        <head>

            <title>Order Submitted - Bobo's Kitchen</title>

            <link rel='stylesheet'
                  href='../CSS file/style.css'>

        </head>

        <body>

            <main>

                <section class='form-section'>

                    <div class='form-card'>

                        <h2 class='page-title'>
                            Order Submitted!
                        </h2>

                        <p class='section-intro'>
                            Thank you, " . htmlspecialchars($customer_name) . ".
                        </p>

                        <p>
                            Your order has been sent to our employees.
                        </p>

                        <p>
                            <strong>Table:</strong>
                            " . htmlspecialchars($table_number) . "
                        </p>

                        <p>
                            <strong>Food:</strong>
                            " . htmlspecialchars($food_item) . "
                        </p>

                        <p>
                            <strong>Quantity:</strong>
                            " . htmlspecialchars($quantity) . "
                        </p>

                        <p>
                            Your order is currently being prepared.
                        </p>

                        <a href='../order.html'
                           class='btn'>
                            Back to Menu
                        </a>

                    </div>

                </section>

            </main>

        </body>

        </html>

    ";

} else {

    echo "

        <h2>Order Failed</h2>

        <p>
            Something went wrong while submitting your order.
        </p>

        <a href='../order.html'>
            Try Again
        </a>

    ";

}

$stmt->close();

$conn->close();

?>