"use strict";
var KTEcommerceUpdateProfile = (function () {
    var formElement, submitButton, formValidation;
    return {
        init: function () {
            formElement = document.querySelector("#kt_ecommerce_customer_profile");
            submitButton = formElement.querySelector("#kt_ecommerce_customer_profile_submit");
            formValidation = FormValidation.formValidation(formElement, {
                fields: {
                    name: { validators: { notEmpty: { message: "Name is required" } } },
                    gen_email: { validators: { notEmpty: { message: "Email is required" } } }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            });

            // submitButton.addEventListener("click", function (e) {
            //     e.preventDefault();
            //     formValidation &&
            //         formValidation.validate().then(function (status) {
            //             if (status == "Valid") {
            //                 submitButton.setAttribute("data-kt-indicator", "on");
            //                 submitButton.disabled = true;

            //                 // AJAX request to update profile
            //                 var formData = $(formElement).serialize();
            //                 $.ajax({
            //                     url: CI_ROOT + 'sellers/update_profile', // Adjust the URL as needed
            //                     type: 'POST',
            //                     data: formData,
            //                     dataType: 'json',
            //                     success: function (response) {
            //                         submitButton.removeAttribute("data-kt-indicator");
            //                         submitButton.disabled = false;
            //                         if (response.success) {
            //                             Swal.fire({
            //                                 text: response.message,
            //                                 icon: "success",
            //                                 buttonsStyling: false,
            //                                 confirmButtonText: "Ok, got it!",
            //                                 customClass: { confirmButton: "btn btn-primary" }
            //                             }).then(function() {
            //                                 location.reload(); // Reload the page on success
            //                             });
            //                         } else {
            //                             Swal.fire({
            //                                 text: response.message,
            //                                 icon: "error",
            //                                 buttonsStyling: false,
            //                                 confirmButtonText: "Ok, got it!",
            //                                 customClass: { confirmButton: "btn btn-primary" }
            //                             });
            //                         }
            //                     },
            //                     error: function (xhr, status, error) {
            //                         console.error('Error updating profile:', error);
            //                         Swal.fire({
            //                             text: "Sorry, there was an error updating your profile. Please try again.",
            //                             icon: "error",
            //                             buttonsStyling: false,
            //                             confirmButtonText: "Ok, got it!",
            //                             customClass: { confirmButton: "btn btn-primary" }
            //                         });
            //                         submitButton.removeAttribute("data-kt-indicator");
            //                         submitButton.disabled = false;
            //                     }
            //                 });
            //             } else {
            //                 Swal.fire({
            //                     text: "Sorry, looks like there are some errors detected, please try again.",
            //                     icon: "error",
            //                     buttonsStyling: false,
            //                     confirmButtonText: "Ok, got it!",
            //                     customClass: { confirmButton: "btn btn-primary" }
            //                 });
            //             }
            //         });
            // });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTEcommerceUpdateProfile.init();
});
