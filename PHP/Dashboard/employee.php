<?php

session_start();

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

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee Dashboard - Bobo's Kitchen</title>

    <!-- Google Font -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- Main CSS -->

    <link rel="stylesheet"
          href="../../CSS file/style.css">

</head>


<body>

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

            <a href="../../PHP/logout.php">
                Logout
            </a>

        </nav>

    </div>

</header>


<main>

    <section class="dashboard-section">

        <div class="dashboard-container">

            <h2 class="page-title">
                Employee Dashboard
            </h2>


            <p class="dashboard-welcome">

                Welcome,
                <strong>
                    <?php echo htmlspecialchars($_SESSION["full_name"]); ?>
                </strong>

            </p>


            <!-- ATTENDANCE -->

            <div class="dashboard-card">

                <h3>
                    Attendance
                </h3>

                <p>
                    Record your working hours.
                </p>


                <div class="dashboard-actions">

                    <form action="attendance.php"
                          method="POST">

                        <input type="hidden"
                               name="action"
                               value="check_in">

                        <button type="submit"
                                class="btn">

                            Check In

                        </button>

                    </form>


                    <form action="attendance.php"
                          method="POST">

                        <input type="hidden"
                               name="action"
                               value="check_out">

                        <button type="submit"
                                class="btn">

                            Check Out

                        </button>

                    </form>

                </div>

            </div>


            <!-- CUSTOMER ORDERS -->

            <div class="dashboard-card">

                <h3>
                    Customer Orders
                </h3>

                <p>
                    Orders placed by customers will appear here.
                </p>


                <div class="order-card">

                    <h4>
                        Example Order
                    </h4>

                    <p>
                        Table Number: 5
                    </p>

                    <p>
                        Food: Burger
                    </p>

                    <p>
                        Quantity: 2
                    </p>

                    <p>
                        Status:
                        <strong>
                            Preparing
                        </strong>
                    </p>


                    <form action="update_order.php"
                          method="POST">

                        <input type="hidden"
                               name="order_id"
                               value="1">

                        <button type="submit"
                                class="btn">

                            Mark as Ready

                        </button>

                    </form>

                </div>

            </div>


        </div>

    </section>

</main>


<footer class="site-footer">

    <p>
        © 2026 Bobo's Kitchen. All Rights Reserved.
    </p>

</footer>

</body>

</html>