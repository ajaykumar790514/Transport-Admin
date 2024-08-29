"use strict";
var KTSigninGeneral = (function () {
    var t, e, r;
    return {
        init: function () {
            (t = document.querySelector("#kt_sign_in_form")),
            (e = document.querySelector("#kt_sign_in_submit")),
            (r = FormValidation.formValidation(t, {
                fields: {
                    username: { 
                        validators: { 
                            // regexp: { regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, message: "The value is not a valid username" }, 
                            notEmpty: { message: "The Username is required" } 
                        } 
                    },
                    password: { 
                        validators: { notEmpty: { message: "The password is required" } } 
                    },
                },
                plugins: { 
                    trigger: new FormValidation.plugins.Trigger(), 
                    bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" }) 
                },
            })),
            e.addEventListener("click", function (i) {
                i.preventDefault();
                r.validate().then(function (r) {
                    if ("Valid" == r) {
                        e.setAttribute("data-kt-indicator", "on");
                        e.disabled = !0;
                        axios.post(t.getAttribute("action"), new FormData(t))
                            .then(function (response) {
                                if (response.data.res === 'success') {
                                    t.reset();
                                    Swal.fire({
                                        text: "You have successfully logged in!",
                                        icon: "success",
                                        buttonsStyling: !1,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: { confirmButton: "btn btn-primary" }
                                    }).then(function (e) {
                                        if (e.isConfirmed) {
											location.href = response.data.redirect_url;
                                            // var redirectUrl = t.getAttribute("data-kt-redirect-url");
                                            // if (redirectUrl) {
                                            //     location.href = redirectUrl;
                                            // }
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        text: response.data.msg,
                                        icon: "error",
                                        buttonsStyling: !1,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: { confirmButton: "btn btn-primary" }
                                    });
                                }
                            })
                            .catch(function (error) {
                                Swal.fire({
                                    text: "Sorry, looks like there are some errors detected, please try again.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: { confirmButton: "btn btn-primary" }
                                });
                            })
                            .then(function () {
                                e.removeAttribute("data-kt-indicator");
                                e.disabled = !1;
                            });
                    } else {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: { confirmButton: "btn btn-primary" }
                        });
                    }
                });
            });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTSigninGeneral.init();
});
