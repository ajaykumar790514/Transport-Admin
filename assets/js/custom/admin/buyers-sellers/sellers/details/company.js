"use strict";

var KTModalAddAddress = (function () {
    var initModal = function (modalId) {
        var modalElement = document.querySelector(`#kt_modal_company_status_${modalId}`);
        if (!modalElement) {
            console.error(`Modal element with ID kt_modal_company_status_${modalId} not found`);
            return;
        }

        var formElement = modalElement.querySelector(`#kt_modal_company_status_form_${modalId}`);
        if (!formElement) {
            // console.error(`Form element with ID kt_modal_company_status_form_${modalId} not found`);
            return;
        }
		
        var submitButton = formElement.querySelector(`#kt_modal_company_status_submit_${modalId}`);
        var cancelButton = formElement.querySelector(`#kt_modal_company_status_cancel_${modalId}`);
        var closeButton = modalElement.querySelector('[data-bs-dismiss="modal"]');
		var verifyStatusSelect = formElement.querySelector(`#kt_modal_company_change_status_${modalId}`);
        if (!submitButton || !cancelButton || !closeButton) {
            console.error(`One or more buttons (submit, cancel, close) not found in the form with ID kt_modal_company_status_form_${modalId}`);
            return;
        }
		var remarkField = formElement.querySelector("[name='remark']").parentElement;
		var formValidation = FormValidation.formValidation(formElement, {
            fields: {
                status: {
                    validators: {
                        notEmpty: {
                            message: "Status is required"
                        }
                    }
                },
                remark: { // Define validators for the remark field
                    validators: {
                        notEmpty: {
                            message: "Rejection Remark is required"
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row",
                    eleInvalidClass: "",
                    eleValidClass: ""
                })
            },
        });

		 // Event listener for select change
		 verifyStatusSelect.addEventListener("change", function (e) {
            e.preventDefault();
            var selectedStatus = verifyStatusSelect.value; // Get the selected value

            if (selectedStatus === "REJECTED") {
                remarkField.classList.remove("d-none");
                formValidation.addField("remark"); // Add validation for remark field
            } else {
                remarkField.classList.add("d-none");
                formValidation.removeField("remark"); // Remove validation for remark field
            }
        });

        submitButton.addEventListener("click", function (e) {
            e.preventDefault();
            formValidation.validate().then(function (status) {
                if (status == "Valid") {
                    submitButton.setAttribute("data-kt-indicator", "on");
                    submitButton.disabled = true;
					// AJAX request to update profile
					var formData = $(formElement).serialize();
					$.ajax({
						url: CI_ROOT + 'sellers/update_company_status', // Adjust the URL as needed
						type: 'POST',
						data: formData,
						dataType: 'json',
						success: function (response) {
							submitButton.removeAttribute("data-kt-indicator");
							submitButton.disabled = false;
							if (response.success) {
								Swal.fire({
									text: response.message,
									icon: "success",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: { confirmButton: "btn btn-primary" }
								}).then(function() {
									location.reload(); // Reload the page on success
								});
							} else {
								Swal.fire({
									text: response.message,
									icon: "error",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: { confirmButton: "btn btn-primary" }
								});
							}
						},
						error: function (xhr, status, error) {
							console.error('Error updating profile:', error);
							Swal.fire({
								text: "Sorry, there was an error updating your profile. Please try again.",
								icon: "error",
								buttonsStyling: false,
								confirmButtonText: "Ok, got it!",
								customClass: { confirmButton: "btn btn-primary" }
							});
							submitButton.removeAttribute("data-kt-indicator");
							submitButton.disabled = false;
						}
					});
                } else {
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: { confirmButton: "btn btn-primary" }
                    });
                }
            });
        });

        cancelButton.addEventListener("click", function (e) {
            e.preventDefault();
            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: { confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light" },
            }).then(function (result) {
                if (result.value) {
                    formElement.reset();
                    bootstrap.Modal.getInstance(modalElement).hide();
                } else if (result.dismiss === "cancel") {
                    Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: { confirmButton: "btn btn-primary" },
                    });
                }
            });
        });

        closeButton.addEventListener("click", function (e) {
            e.preventDefault();
            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: { confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light" },
            }).then(function (result) {
                if (result.value) {
                    formElement.reset();
                    bootstrap.Modal.getInstance(modalElement).hide();
                } else if (result.dismiss === "cancel") {
                    Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: { confirmButton: "btn btn-primary" },
                    });
                }
            });
        });

    };

    return {
        init: function () {
            document.querySelectorAll("[id^=kt_modal_company_status_]").forEach(function (modal) {
                var modalId = modal.id.replace("kt_modal_company_status_", "");
                initModal(modalId);
            });
        },
    };
})();


function load_company(content)
{

	if(content=='company'  &&  !KTModalAddAddress.isInitialized)
		{
				document.getElementById('loader').style.display = 'block';
				document.getElementById('company_content').style.display = 'none';
				setTimeout(function() {
					document.getElementById('loader').style.display = 'none';
					document.getElementById('company_content').style.display = 'block';
				}, 1000);
			KTModalAddAddress.init();
			KTCategoryList.KTModalAddAddress = true;
		}
}


function verify_status(selectedStatus, formId) {
    var form = document.querySelector(`#kt_modal_company_status_form_${formId}`);
    if (!form) return;

    var remarkField = form.querySelector("[name='remark']").parentElement;
    if (!remarkField) return;

    if (selectedStatus === "REJECTED") {
        remarkField.classList.remove("d-none");
        FormValidation.formValidation(form).addField("remark", {
            validators: {
                notEmpty: {
                    message: "Rejection Remark is required"
                }
            }
        });
    } else {
        remarkField.classList.add("d-none");
        FormValidation.formValidation(form).removeField("remark");
    }
}
