<?php

session_start();

require_once "../db.php";


/*
|--------------------------------------------------------------------------
| Check if user is logged in
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {

    header("Location: ../../login.html");

    exit();

}


/*
|--------------------------------------------------------------------------
| Check if user is an employer
|--------------------------------------------------------------------------
*/

if ($_SESSION["role"] !== "employer") {

    header("Location: ../../login.html");

    exit();

}


$employer_name = $_SESSION["username"];


/*
|--------------------------------------------------------------------------
| Get employee attendance records
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT
        attendance.attendance_id,
        attendance.user_id,
        attendance.check_in,
        attendance.check_out,
        users.username
    FROM attendance

    INNER JOIN users
        ON attendance.user_id = users.user_id

    ORDER BY attendance.check_in DESC
";


$result = $conn->query($sql);


if (!$result) {

    die(
        "Database Error: " .
        $conn->error
    );

}


/*
|--------------------------------------------------------------------------
| Get customer orders
|--------------------------------------------------------------------------
*/

$order_sql = "
    SELECT
        order_id,
        customer_name,
        table_number,
        food_item,
        quantity,
        special_instructions,
        status,
        order_date
    FROM orders

    ORDER BY order_date DESC
";


$order_result = $conn->query($order_sql);


if (!$order_result) {

    die(
        "Order Database Error: " .
        $conn->error
    );

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Employer Dashboard - Bobo's Kitchen
    </title>


    <!-- Google Font -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >


    <!-- Main CSS -->

    <link
        rel="stylesheet"
        href="../../CSS file/style.css"
    >

</head>


<body>


<!-- =========================================================
     HEADER
========================================================= -->

<header>

    <div class="container">

        <h1>
            Bobo's Kitchen
        </h1>


        <nav>

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



<!-- =========================================================
     MAIN DASHBOARD
========================================================= -->

<main class="dashboard-container">


    <h2 class="page-title">
        Employer Dashboard
    </h2>


    <p class="dashboard-welcome">

        Welcome,
        <strong>
            <?php echo htmlspecialchars($employer_name); ?>
        </strong>

    </p>



    <!-- =====================================================
         EMPLOYEE ATTENDANCE
    ====================================================== -->

    <section class="dashboard-card">

        <h2>
            Employee Attendance
        </h2>

        <p>
            Monitor employee check-in and check-out times.
        </p>


        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>
                            Employee
                        </th>

                        <th>
                            Check In
                        </th>

                        <th>
                            Check Out
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                <?php

                if ($result->num_rows > 0) {

                    while (
                        $attendance =
                        $result->fetch_assoc()
                    ) {

                ?>

                    <tr>

                        <td>

                            <?php

                            echo htmlspecialchars(
                                $attendance["username"]
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $attendance["check_in"]
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            if (
                                $attendance["check_out"] !== null
                            ) {

                                echo htmlspecialchars(
                                    $attendance["check_out"]
                                );

                            } else {

                                echo "Not checked out";

                            }

                            ?>

                        </td>


                        <td>

                            <?php

                            if (
                                $attendance["check_out"] === null
                            ) {

                                echo "<strong>Working</strong>";

                            } else {

                                echo "Checked Out";

                            }

                            ?>

                        </td>

                    </tr>


                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td
                            colspan="4"
                        >

                            No attendance records found.

                        </td>

                    </tr>

                <?php

                }

                ?>

                </tbody>

            </table>

        </div>

    </section>



    <!-- =====================================================
         CUSTOMER ORDERS
    ====================================================== -->

    <section class="dashboard-card">

        <h2>
            Customer Orders
        </h2>

        <p>
            Monitor orders submitted by customers.
        </p>


        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>
                            Order ID
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Table
                        </th>

                        <th>
                            Food
                        </th>

                        <th>
                            Quantity
                        </th>

                        <th>
                            Instructions
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Order Time
                        </th>

                    </tr>

                </thead>


                <tbody>

                <?php

                if (
                    $order_result->num_rows > 0
                ) {

                    while (
                        $order =
                        $order_result->fetch_assoc()
                    ) {

                ?>

                    <tr>

                        <td>

                            <?php

                            echo htmlspecialchars(
                                $order["order_id"]
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $order["customer_name"]
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $order["table_number"]
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $order["food_item"]
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $order["quantity"]
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $order["special_instructions"]
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $order["status"]
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $order["order_date"]
                            );

                            ?>

                        </td>

                    </tr>


                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td
                            colspan="8"
                        >

                            No customer orders found.

                        </td>

                    </tr>

                <?php

                }

                ?>

                </tbody>

            </table>

        </div>

    </section>



    <!-- =====================================================
         FUTURE EMPLOYEE MANAGEMENT
    ====================================================== -->

    <section class="dashboard-card">

        <h2>
            Employee Management
        </h2>

        <p>
            Employee management features will be added here.
        </p>


        <div class="dashboard-buttons">

            <button
                type="button"
                class="btn"
                disabled
            >
                Add Employee
            </button>


            <button
                type="button"
                class="btn"
                disabled
            >
                Delete Employee
            </button>

        </div>

    </section>


</main>



<!-- =========================================================
     FOOTER
========================================================= -->

<footer>

    <p>
        © 2026 Bobo's Kitchen.
        All Rights Reserved.
    </p>

</footer>



</body>

</html>


<?php

$conn->close();

?>