<?php

session_start();


/*
|--------------------------------------------------------------------------
| Employee Dashboard
|--------------------------------------------------------------------------
|
| Database authentication will be added later.
|
*/

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Employee Dashboard - Bobo's Kitchen</title>


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

            <a href="dashboard.php"
               class="active">
                Dashboard
            </a>

            <a href="attendance.php">
                Attendance
            </a>

            <a href="orders.php">
                Orders
            </a>

            <a href="../../PHP/logout.php">
                Logout
            </a>

        </nav>

    </div>

</header>


<main>

    <section class="content-section">

        <h2 class="page-title">
            Employee Dashboard
        </h2>


        <p class="section-intro">

            Welcome to the Bobo's Kitchen
            employee dashboard.

        </p>


        <div class="card-container">

            <div class="info-card">

                <h3>Attendance</h3>

                <p>
                    Record your working hours.
                </p>

                <a href="attendance.php"
                   class="btn">

                    Check In / Out

                </a>

            </div>


            <div class="info-card">

                <h3>Customer Orders</h3>

                <p>
                    View and process customer orders.
                </p>

                <a href="orders.php"
                   class="btn">

                    View Orders

                </a>

            </div>


            <div class="info-card">

                <h3>Employee Information</h3>

                <p>
                    View current employees.
                </p>

                <a href="employees.php"
                   class="btn">

                    View Employees

                </a>

            </div>

        </div>

    </section>

</main>


<footer class="site-footer">

    <p>
        © 2026 Bobo's Kitchen
    </p>

</footer>

</body>

</html>