"use strict";

var KTAuthNewPassword = (function () {
    var t, e, r, o, n = function () {
        return o.getScore() > 50;
    };
    
    return {
        init: function () {
            t = document.querySelector("#kt_new_password_form");
            e = document.querySelector("#kt_new_password_submit");
            o = KTPasswordMeter.getInstance(t.querySelector('[data-kt-password-meter="true"]'));
            r = FormValidation.formValidation(t, {
                fields: {
                    password: {
                        validators: {
                            notEmpty: {
                                message: "The password is required"
                            },
							callback: {
								message: "Please enter a valid password",
								callback: function (t) {
									var password = t.value;
									// Check if password has at least one uppercase, one lowercase, one number, and one special character
									var hasUpperCase = /[A-Z]/.test(password);
									var hasLowerCase = /[a-z]/.test(password);
									var hasNumber = /[0-9]/.test(password);
									var hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password); // Update with your list of special characters
							
									return password.length >= 8 && hasUpperCase && hasLowerCase && hasNumber && hasSpecialChar;
								}
							}
							
                        }
                    },
                    "confirm-password": {
                        validators: {
                            notEmpty: {
                                message: "The password confirmation is required"
                            },
                            identical: {
                                compare: function () {
                                    return t.querySelector('[name="password"]').value;
                                },
                                message: "The password and its confirm are not the same"
                            }
                        }
                    },
                    toc: {
                        validators: {
                            notEmpty: {
                                message: "You must accept the terms and conditions"
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger({
                        event: {
                            password: !1
                        }
                    }),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            });

            // Event listener for form submission
            e.addEventListener("click", function (event) {
                event.preventDefault();
                r.revalidateField("password");
                r.validate().then(function (status) {
                    if (status === "Valid") {
                        e.setAttribute("data-kt-indicator", "on");
                        e.disabled = !0;

                        // Prepare form data
                        var formData = new FormData(t);

                        // Send AJAX request using Axios
                        axios.post(t.getAttribute("action"), formData)
                            .then(function (response) {
                                if (response.data.res === "success") {
                                    Swal.fire({
                                        text: "You have successfully reset your password!",
                                        icon: "success",
                                        buttonsStyling: !1,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function () {
                                        t.querySelector('[name="password"]').value = "";
                                        t.querySelector('[name="confirm-password"]').value = "";
                                        o.reset();
                                            location.href = response.data.redirect_url;
                                    });
                                } else {
                                    Swal.fire({
                                        text: "Failed to update password. Please try again.",
                                        icon: "error",
                                        buttonsStyling: !1,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                }
                            })
                            .catch(function (error) {
                                Swal.fire({
                                    text: "Sorry, looks like there are some errors detected. Please try again.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            })
                            .then(function () {
                                e.removeAttribute("data-kt-indicator");
                                e.disabled = !1;
                            });
                    } else {
                        Swal.fire({
                            text: "Please correct the errors in the form and try again.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            });
        }
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTAuthNewPassword.init();
});
