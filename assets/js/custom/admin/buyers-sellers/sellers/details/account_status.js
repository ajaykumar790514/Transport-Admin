"use strict";

var KTModalAccountStatus = (function () {
    var modalElement, formElement, submitButton, cancelButton, closeButton, verifyStatusSelect, remarkField, formValidation;

    var initModal = function () {
        modalElement = document.querySelector('#kt_modal_account_status');
        if (!modalElement) {
            console.error('Account status modal element not found');
            return;
        }

        formElement = modalElement.querySelector('#kt_modal_account_status_form');
        if (!formElement) {
            console.error('Account status form element not found');
            return;
        }

        submitButton = formElement.querySelector('#kt_modal_account_status_submit');
        cancelButton = formElement.querySelector('#kt_modal_account_status_cancel');
        closeButton = modalElement.querySelector('[data-bs-dismiss="modal"]');
        verifyStatusSelect = formElement.querySelector('#kt_modal_account_status_name');
        remarkField = formElement.querySelector('[name="account_remark"]').parentElement;

        if (!submitButton || !cancelButton || !closeButton || !verifyStatusSelect || !remarkField) {
            console.error('One or more required elements not found');
            return;
        }

        formValidation = FormValidation.formValidation(formElement, {
            fields: {
                account_status: {
                    validators: {
                        notEmpty: {
                            message: 'Account status is required'
                        }
                    }
                },
                account_remark: {
                    validators: {
                        notEmpty: {
                            message: 'Rejection Remark is required'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
            },
        });

        // Event listener for select change
        verifyStatusSelect.addEventListener('change', function (e) {
            e.preventDefault();
            var selectedStatus = verifyStatusSelect.value;

            if (selectedStatus === 'REJECTED') {
                remarkField.classList.remove('d-none');
                formValidation.addField('account_remark');
            } else {
                remarkField.classList.add('d-none');
                formValidation.removeField('account_remark');
            }
        });

        // Handle form submission
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            formValidation.validate().then(function (status) {
                if (status == 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;
                   // AJAX request to update profile
					var formData = $(formElement).serialize();
					$.ajax({
						url: CI_ROOT + 'sellers/update_account_status', // Adjust the URL as needed
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
                        text: 'Please change status than click submit button.',
                        icon: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok, got it!',
                        customClass: { confirmButton: 'btn btn-primary' }
                    });
                }
            });
        });

        // Handle cancel button click
        cancelButton.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                text: 'Are you sure you would like to cancel?',
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'No, return',
                customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-active-light' },
            }).then(function (result) {
                if (result.value) {
                    formElement.reset();
                    bootstrap.Modal.getInstance(modalElement).hide();
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: 'Your form has not been cancelled!.',
                        icon: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok, got it!',
                        customClass: { confirmButton: 'btn btn-primary' },
                    });
                }
            });
        });

        // Handle close button click
        closeButton.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                text: 'Are you sure you would like to cancel?',
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'No, return',
                customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-active-light' },
            }).then(function (result) {
                if (result.value) {
                    formElement.reset();
                    bootstrap.Modal.getInstance(modalElement).hide();
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: 'Your form has not been cancelled!.',
                        icon: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok, got it!',
                        customClass: { confirmButton: 'btn btn-primary' },
                    });
                }
            });
        });
    };

    return {
        init: function () {
            KTUtil.onDOMContentLoaded(function () {
                initModal();
            });
        }
    };
})();

// Initialize KTModalAccountStatus
KTModalAccountStatus.init();
