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
   2. DARK / LIGHT MODE
   ========================================================= */

const themeToggle =
    document.getElementById("themeToggle");


const savedTheme =
    localStorage.getItem("theme");


if (savedTheme === "dark") {

    document.body.classList.add(
        "dark-mode"
    );

}


if (themeToggle) {

    updateThemeButton();


    themeToggle.addEventListener(
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

            } else {

                localStorage.setItem(
                    "theme",
                    "light"
                );

            }


            updateThemeButton();

        }
    );

}


function updateThemeButton() {

    if (!themeToggle) {
        return;
    }


    if (
        document.body.classList.contains(
            "dark-mode"
        )
    ) {

        themeToggle.textContent =
            "☀️ Light Mode";

    } else {

        themeToggle.textContent =
            "🌙 Dark Mode";

    }

}


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

}