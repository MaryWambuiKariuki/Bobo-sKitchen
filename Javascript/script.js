/* =========================================================
   BOBO'S KITCHEN
   EXTERNAL JAVASCRIPT
   ========================================================= */


/* =========================================================
   1. WELCOME MESSAGE
   ========================================================= */

const welcomeMessage =
    document.getElementById("welcomeMessage");


if (welcomeMessage) {

    let customerName =
        localStorage.getItem("customerName");


    if (!customerName) {

        customerName =
            prompt(
                "Welcome to Bobo's Kitchen! What is your name?"
            );


        if (customerName) {

            customerName =
                customerName.trim();

            localStorage.setItem(
                "customerName",
                customerName
            );

        }

    }


    if (customerName) {

        welcomeMessage.textContent =
            "Welcome to Bobo's Kitchen, " +
            customerName + "!";

    }

}


/* =========================================================
   2. LIGHT / DARK MODE
   ========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const themeButton =
        document.getElementById("themeToggle");


    if (!themeButton) {
        return;
    }


    /* Check saved theme */

    const savedTheme =
        localStorage.getItem("theme");


    if (savedTheme === "dark") {

        document.body.classList.add("dark-mode");

        themeButton.textContent =
            "Light Mode";

    } else {

        document.body.classList.remove("dark-mode");

        themeButton.textContent =
            "Dark Mode";

    }


    /* Change theme when button is clicked */

    themeButton.addEventListener(
        "click",
        function () {

            document.body.classList.toggle(
                "dark-mode"
            );


            if (
                document.body.classList.contains(
                    "dark-mode"
                )
            ) {

                localStorage.setItem(
                    "theme",
                    "dark"
                );

                themeButton.textContent =
                    "Light Mode";

            } else {

                localStorage.setItem(
                    "theme",
                    "light"
                );

                themeButton.textContent =
                    "Dark Mode";

            }

        }
    );

});

/* =========================================================
   3. FORM VALIDATION
   ========================================================= */

const forms =
    document.querySelectorAll("form");


forms.forEach(
    function (form) {

        form.addEventListener(
            "submit",
            function (event) {

                const requiredFields =
                    form.querySelectorAll(
                        "[required]"
                    );


                let valid = true;


                const oldError =
                    form.querySelector(
                        ".form-error"
                    );


                if (oldError) {

                    oldError.remove();

                }


                requiredFields.forEach(
                    function (field) {

                        if (
                            field.value.trim() === ""
                        ) {

                            valid = false;

                            field.classList.add(
                                "input-error"
                            );

                        } else {

                            field.classList.remove(
                                "input-error"
                            );

                        }

                    }
                );


                if (!valid) {

                    event.preventDefault();


                    const error =
                        document.createElement(
                            "p"
                        );


                    error.className =
                        "form-error";


                    error.textContent =
                        "Please complete all required fields.";


                    form.prepend(error);

                }

            }
        );

    }
);


/* =========================================================
   4. ORDER CONFIRMATION
   ========================================================= */

const orderForm =
    document.getElementById("orderForm");


if (orderForm) {

    orderForm.addEventListener(
        "submit",
        function (event) {

            event.preventDefault();


            const customerName =
                document.getElementById(
                    "customerName"
                ).value.trim();


            const tableNumber =
                document.getElementById(
                    "tableNumber"
                ).value;


            const foodItem =
                document.getElementById(
                    "foodItem"
                ).value;


            const quantity =
                document.getElementById(
                    "quantity"
                ).value;


            const confirmation =
                document.getElementById(
                    "orderConfirmation"
                );


            if (
                customerName &&
                tableNumber &&
                foodItem &&
                quantity
            ) {

                confirmation.textContent =
                    "Thank you, " +
                    customerName +
                    "! Your order of " +
                    quantity +
                    " " +
                    foodItem +
                    "(s) for Table " +
                    tableNumber +
                    " has been received.";


                confirmation.classList.add(
                    "show"
                );


                confirmation.scrollIntoView({
                    behavior: "smooth"
                });

            }

        }
    );

}


/* =========================================================
   5. SHOW / HIDE INFORMATION
   ========================================================= */

const informationButton =
    document.getElementById(
        "informationButton"
    );


const additionalInformation =
    document.getElementById(
        "additionalInformation"
    );


if (
    informationButton &&
    additionalInformation
) {

    informationButton.addEventListener(
        "click",
        function () {

            additionalInformation.classList.toggle(
                "hidden"
            );


            if (
                additionalInformation.classList.contains(
                    "hidden"
                )
            ) {

                informationButton.textContent =
                    "Learn More About Us";

            } else {

                informationButton.textContent =
                    "Hide Information";

            }

        }
    );

}

/* =========================================================
   6. REVIEW CONFIRMATION
   ========================================================= */

const reviewForm =
    document.getElementById(
        "reviewForm"
    );


if (reviewForm) {

    reviewForm.addEventListener(
        "submit",
        function (event) {

            event.preventDefault();


            const confirmation =
                document.getElementById(
                    "reviewConfirmation"
                );


            if (confirmation) {

                confirmation.textContent =
                    "Thank you for your review!";

                confirmation.classList.add(
                    "show"
                );

            }

        }
    );

    /*
|--------------------------------------------------------------------------
| LOAD FOOD REVIEWS
|--------------------------------------------------------------------------
*/

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const reviewContainers =
            document.querySelectorAll(
                ".review-list"
            );


        reviewContainers.forEach(
            function (container) {

                const foodItem =
                    container.id.replace(
                        "reviews-",
                        ""
                    );


                fetch(
                    "PHP/get_reviews.php?food_item=" +
                    encodeURIComponent(foodItem)
                )

                .then(
                    function (response) {

                        return response.json();

                    }
                )

                .then(
                    function (reviews) {

                        container.innerHTML = "";


                        if (
                            reviews.length === 0
                        ) {

                            container.innerHTML =
                                "<p>No reviews yet.</p>";

                            return;

                        }


                        reviews.forEach(
                            function (review) {

                                const reviewBox =
                                    document.createElement(
                                        "div"
                                    );


                                reviewBox.className =
                                    "review-box";


                                reviewBox.innerHTML =

                                    "<p>\"" +
                                    escapeHTML(
                                        review.review
                                    ) +
                                    "\"</p>" +

                                    "<strong>- " +
                                    escapeHTML(
                                        review.customer_name
                                    ) +
                                    "</strong>";


                                container.appendChild(
                                    reviewBox
                                );

                            }
                        );

                    }
                )

                .catch(
                    function (error) {

                        console.error(
                            "Error loading reviews:",
                            error
                        );

                        container.innerHTML =
                            "<p>Unable to load reviews.</p>";

                    }
                );

            }
        );

    }
);

}

/*
|--------------------------------------------------------------------------
| PREVENT HTML INJECTION
|--------------------------------------------------------------------------
*/

function escapeHTML(text) {

    const div =
        document.createElement("div");

    div.textContent = text;

    return div.innerHTML;

}