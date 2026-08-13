<?php

require_once "db.php";


/*
|--------------------------------------------------------------------------
| Only allow POST requests
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../order.html");

    exit();

}


/*
|--------------------------------------------------------------------------
| Get information from the form
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

        <p>
            Please complete all required fields.
        </p>

        <a href='../order.html'>
            Return to Order Page
        </a>
    ");

}


/*
|--------------------------------------------------------------------------
| New orders start as Pending
|--------------------------------------------------------------------------
*/

$status = "Pending";


/*
|--------------------------------------------------------------------------
| Insert order into database
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| Check whether SQL statement was prepared successfully
|--------------------------------------------------------------------------
*/

if (!$stmt) {

    die(
        "SQL Error: " . $conn->error
    );

}


/*
|--------------------------------------------------------------------------
| Bind values
|--------------------------------------------------------------------------
|
| s = string
| i = integer
|
*/

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
| Execute
|--------------------------------------------------------------------------
*/

if ($stmt->execute()) {

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Order Submitted - Bobo's Kitchen</title>

    <link rel="stylesheet"
          href="../CSS file/style.css">

</head>


<body>

    <main>

        <section class="form-section">

            <div class="form-card">

                <h2 class="page-title">
                    Order Submitted!
                </h2>


                <p class="section-intro">

                    Thank you,
                    <?php echo htmlspecialchars($customer_name); ?>!

                </p>


                <p>
                    Your order has been received
                    by Bobo's Kitchen.
                </p>


                <p>

                    <strong>
                        Table Number:
                    </strong>

                    <?php echo htmlspecialchars($table_number); ?>

                </p>


                <p>

                    <strong>
                        Food:
                    </strong>

                    <?php echo htmlspecialchars($food_item); ?>

                </p>


                <p>

                    <strong>
                        Quantity:
                    </strong>

                    <?php echo htmlspecialchars($quantity); ?>

                </p>


                <?php if (!empty($special_instructions)) { ?>

                    <p>

                        <strong>
                            Special Instructions:
                        </strong>

                        <?php
                        echo htmlspecialchars(
                            $special_instructions
                        );
                        ?>

                    </p>

                <?php } ?>


                <p>

                    <strong>
                        Status:
                    </strong>

                    Pending

                </p>


                <a
                    href="../order.html"
                    class="btn"
                >
                    Back to Menu
                </a>

            </div>

        </section>

    </main>

</body>

</html>

<?php

} else {

    echo "

        <h2>Order Failed</h2>

        <p>
            Something went wrong while saving your order.
        </p>

        <p>
            Error:
            " . htmlspecialchars($stmt->error) . "
        </p>

        <a href='../order.html'>
            Try Again
        </a>

    ";

}


$stmt->close();

$conn->close();

?>