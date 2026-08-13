<?php

session_start();

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - Bobo's Kitchen</title>


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

            <a href="employees.php">
                Employees
            </a>

            <a href="employers.php">
                Employers
            </a>

            <a href="orders.php">
                Orders
            </a>

            <a href="../logout.php">
                Logout
            </a>

        </nav>

    </div>

</header>


<main>

    <section class="content-section">

        <h2 class="page-title">
            Administrator Dashboard
        </h2>


        <p class="section-intro">

            Administrator control centre for
            Bobo's Kitchen.

        </p>


        <div class="card-container">


            <div class="info-card">

                <h3>Employees</h3>

                <p>
                    Add, remove and monitor employees.
                </p>

                <a href="employees.php"
                   class="btn">

                    Manage Employees

                </a>

            </div>


            <div class="info-card">

                <h3>Employers</h3>

                <p>
                    Manage employer accounts.
                </p>

                <a href="employers.php"
                   class="btn">

                    Manage Employers

                </a>

            </div>


            <div class="info-card">

                <h3>Orders</h3>

                <p>
                    Monitor all restaurant orders.
                </p>

                <a href="orders.php"
                   class="btn">

                    View Orders

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