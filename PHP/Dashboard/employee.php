<?php

session_start();

require_once "../db.php";


/*
|--------------------------------------------------------------------------
| Make sure the user is logged in
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {

    header("Location: ../../login.html");

    exit();

}


/*
|--------------------------------------------------------------------------
| Make sure the user is an employee
|--------------------------------------------------------------------------
*/

if ($_SESSION["role"] !== "employee") {

    header("Location: ../../login.html");

    exit();

}


$user_id = $_SESSION["user_id"];

$username = $_SESSION["username"] ?? "Employee";

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Employee Dashboard - Bobo's Kitchen</title>


    <!-- Google Font -->

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">


    <!-- External CSS -->

    <link rel="stylesheet"
          href="../../CSS file/style.css">

</head>


<body>


<!-- =========================
     HEADER
========================= -->

<header class="site-header">

    <div class="header-container">

        <h1 class="logo">
            Bobo's Kitchen
        </h1>


        <nav class="navbar">

            <a href="../../index.html">
                Home
            </a>

            <a href="../../order.html">
                Order
            </a>

            <a href="../../contact.html">
                Contact
            </a>

            <a href="../logout.php">
                Logout
            </a>

        </nav>

    </div>

</header>



<!-- =========================
     MAIN
========================= -->

<main>


<section class="dashboard-section">

    <div class="dashboard-container">


        <h2 class="page-title">
            Employee Dashboard
        </h2>


        <p class="section-intro">

            Welcome,
            <strong>
                <?php echo htmlspecialchars($username); ?>
            </strong>

        </p>



        <!-- =========================
             ATTENDANCE
        ========================= -->

        <div class="dashboard-card">

            <h3>
                Employee Attendance
            </h3>


            <p>
                Record your working hours.
            </p>


            <div class="dashboard-buttons">


                <!-- CHECK IN -->

                <form
                    action="../attendance.php"
                    method="POST"
                >

                    <input
                        type="hidden"
                        name="action"
                        value="check_in"
                    >

                    <button
                        type="submit"
                        class="btn"
                    >
                        Check In
                    </button>

                </form>



                <!-- CHECK OUT -->

                <form
                    action="../attendance.php"
                    method="POST"
                >

                    <input
                        type="hidden"
                        name="action"
                        value="check_out"
                    >

                    <button
                        type="submit"
                        class="btn"
                    >
                        Check Out
                    </button>

                </form>


            </div>

        </div>



        <!-- =========================
             CUSTOMER ORDERS
        ========================= -->

        <div class="dashboard-card">

            <h3>
                Customer Orders
            </h3>


            <p>
                View orders submitted by customers.
            </p>


            <div class="orders-container">


<?php

/*
|--------------------------------------------------------------------------
| Get customer orders
|--------------------------------------------------------------------------
*/

$sql = "SELECT
            order_id,
            customer_name,
            table_number,
            food_item,
            quantity,
            special_instructions,
            status,
            order_date

        FROM orders

        ORDER BY order_date DESC";


$result = $conn->query($sql);


if (!$result) {

    echo "<p>Unable to load customer orders.</p>";

} elseif ($result->num_rows === 0) {

    echo "<p>No customer orders have been placed yet.</p>";

} else {


    while ($order = $result->fetch_assoc()) {

?>



                <!-- =========================
                     ORDER CARD
                ========================= -->

                <div class="order-card">


                    <h4>

                        Order #
                        <?php
                        echo htmlspecialchars(
                            $order["order_id"]
                        );
                        ?>

                    </h4>


                    <p>

                        <strong>
                            Customer:
                        </strong>

                        <?php
                        echo htmlspecialchars(
                            $order["customer_name"]
                        );
                        ?>

                    </p>


                    <p>

                        <strong>
                            Table:
                        </strong>

                        <?php
                        echo htmlspecialchars(
                            $order["table_number"]
                        );
                        ?>

                    </p>


                    <p>

                        <strong>
                            Food:
                        </strong>

                        <?php
                        echo htmlspecialchars(
                            $order["food_item"]
                        );
                        ?>

                    </p>


                    <p>

                        <strong>
                            Quantity:
                        </strong>

                        <?php
                        echo htmlspecialchars(
                            $order["quantity"]
                        );
                        ?>

                    </p>


                    <?php

                    if (
                        !empty(
                            $order["special_instructions"]
                        )
                    ) {

                    ?>

                    <p>

                        <strong>
                            Special Instructions:
                        </strong>

                        <?php

                        echo htmlspecialchars(
                            $order["special_instructions"]
                        );

                        ?>

                    </p>

                    <?php

                    }

                    ?>


                    <p>

                        <strong>
                            Order Time:
                        </strong>

                        <?php

                        echo htmlspecialchars(
                            $order["order_date"]
                        );

                        ?>

                    </p>


                    <p>

                        <strong>
                            Status:
                        </strong>

                        <span class="order-status">

                            <?php

                            echo htmlspecialchars(
                                $order["status"]
                            );

                            ?>

                        </span>

                    </p>



                    <!-- =========================
                         MARK READY BUTTON
                    ========================= -->

                    <?php

                    if ($order["status"] === "Pending") {

                    ?>

                    <form
                        action="../update_order.php"
                        method="POST"
                    >

                        <input
                            type="hidden"
                            name="order_id"
                            value="<?php
                            echo $order["order_id"];
                            ?>"
                        >


                        <input
                            type="hidden"
                            name="status"
                            value="Ready"
                        >


                        <button
                            type="submit"
                            class="btn"
                        >
                            Mark as Ready
                        </button>

                    </form>

                    <?php

                    } else {

                    ?>

                    <p>
                        <strong>
                            ✓ Order is ready
                        </strong>
                    </p>

                    <?php

                    }

                    ?>

                </div>



<?php

    }

}

?>


            </div>

        </div>


    </div>

</section>


</main>



<!-- =========================
     FOOTER
========================= -->

<footer class="site-footer">

    <p>
        © 2026 Bobo's Kitchen.
        Employee Dashboard.
    </p>

</footer>


</body>

</html>