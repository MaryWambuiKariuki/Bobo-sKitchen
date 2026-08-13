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
| Only admin can access this page
|--------------------------------------------------------------------------
*/

if ($_SESSION["role"] !== "admin") {

    header("Location: ../../login.html");

    exit();

}


$admin_name = $_SESSION["username"];


/*
|--------------------------------------------------------------------------
| Get all employees
|--------------------------------------------------------------------------
*/

$employee_sql = "
    SELECT
        user_id,
        username
    FROM users
    WHERE role = 'employee'
    ORDER BY username ASC
";

$employee_result = $conn->query($employee_sql);


if (!$employee_result) {

    die(
        "Employee Database Error: " .
        $conn->error
    );

}


/*
|--------------------------------------------------------------------------
| Get all employers
|--------------------------------------------------------------------------
*/

$employer_sql = "
    SELECT
        user_id,
        username
    FROM users
    WHERE role = 'employer'
    ORDER BY username ASC
";

$employer_result = $conn->query($employer_sql);


if (!$employer_result) {

    die(
        "Employer Database Error: " .
        $conn->error
    );

}


/*
|--------------------------------------------------------------------------
| Get attendance records
|--------------------------------------------------------------------------
*/

$attendance_sql = "
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

$attendance_result =
    $conn->query($attendance_sql);


if (!$attendance_result) {

    die(
        "Attendance Database Error: " .
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

$order_result =
    $conn->query($order_sql);


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
        Admin Dashboard - Bobo's Kitchen
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
     MAIN ADMIN DASHBOARD
========================================================= -->

<main class="dashboard-container">


    <h2 class="page-title">
        Admin Dashboard
    </h2>


    <p class="dashboard-welcome">

        Welcome,
        <strong>
            <?php

            echo htmlspecialchars(
                $admin_name
            );

            ?>
        </strong>

    </p>



    <!-- =====================================================
         STAFF OVERVIEW
    ====================================================== -->

    <section class="dashboard-card">

        <h2>
            Staff Overview
        </h2>

        <p>
            Monitor the employees and employers
            registered on the system.
        </p>


        <div class="dashboard-summary">


            <div class="summary-card">

                <h3>
                    Employees
                </h3>

                <p>

                    <?php

                    echo $employee_result->num_rows;

                    ?>

                </p>

            </div>


            <div class="summary-card">

                <h3>
                    Employers
                </h3>

                <p>

                    <?php

                    echo $employer_result->num_rows;

                    ?>

                </p>

            </div>


        </div>

    </section>



    <!-- =====================================================
         EMPLOYEES
    ====================================================== -->

    <section class="dashboard-card">

        <h2>
            Employees
        </h2>

        <p>
            View all employees registered
            in Bobo's Kitchen.
        </p>


        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>
                            User ID
                        </th>

                        <th>
                            Username
                        </th>

                    </tr>

                </thead>


                <tbody>

                <?php

                if (
                    $employee_result->num_rows > 0
                ) {

                    while (
                        $employee =
                        $employee_result->fetch_assoc()
                    ) {

                ?>

                    <tr>

                        <td>

                            <?php

                            echo htmlspecialchars(
                                $employee["user_id"]
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $employee["username"]
                            );

                            ?>

                        </td>

                    </tr>

                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td colspan="2">

                            No employees found.

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
         EMPLOYERS
    ====================================================== -->

    <section class="dashboard-card">

        <h2>
            Employers
        </h2>

        <p>
            View all employers registered
            in Bobo's Kitchen.
        </p>


        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>
                            User ID
                        </th>

                        <th>
                            Username
                        </th>

                    </tr>

                </thead>


                <tbody>

                <?php

                if (
                    $employer_result->num_rows > 0
                ) {

                    while (
                        $employer =
                        $employer_result->fetch_assoc()
                    ) {

                ?>

                    <tr>

                        <td>

                            <?php

                            echo htmlspecialchars(
                                $employer["user_id"]
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $employer["username"]
                            );

                            ?>

                        </td>

                    </tr>

                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td colspan="2">

                            No employers found.

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
         ATTENDANCE
    ====================================================== -->

    <section class="dashboard-card">

        <h2>
            Employee Attendance
        </h2>

        <p>
            Monitor employee working hours.
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

                if (
                    $attendance_result->num_rows > 0
                ) {

                    while (
                        $attendance =
                        $attendance_result->fetch_assoc()
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
                                $attendance["check_out"]
                                !== null
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
                                $attendance["check_out"]
                                === null
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

                        <td colspan="4">

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
            View all orders submitted
            by customers.
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

                        <td colspan="7">

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
         FUTURE ADMIN MANAGEMENT
    ====================================================== -->

    <section class="dashboard-card">

        <h2>
            Staff Management
        </h2>

        <p>
            Admin management functions will be
            added in the next step.
        </p>

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