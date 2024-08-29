"use strict";

var KTAuthResetPassword = (function () {
	var t, e, r;
	return {
		init: function () {
			t = document.querySelector("#kt_password_reset_form");
			e = document.querySelector("#kt_password_reset_submit");

			r = FormValidation.formValidation(t, {
				fields: {
					mobile: {
						validators: {
							regexp: {
								regexp: /^[0-9]{10}$/,
								message: "The value is not a valid mobile number"
							},
							notEmpty: {
								message: "Mobile number is required"
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
				}
			});

			e.addEventListener("click", function (i) {
				i.preventDefault();
				r.validate().then(function (status) {
					if (status === "Valid") {
						e.setAttribute("data-kt-indicator", "on");
						e.disabled = true;

						axios.post(t.getAttribute("action"), new FormData(t))
							.then(function (response) {
								if (response.data.res === 'success') {
									t.reset();
									document.getElementById("mobile_div").style.display = "none";
									document.getElementById("otp_sent_div").style.display = "block";
									$("#mobile_number").val(response.data.mobile);
									Swal.fire({
										text: response.data.msg,
										icon: "success",
										buttonsStyling: false,
										confirmButtonText: "Ok, got it!",
										customClass: { confirmButton: "btn btn-primary" }
									});
								} else {
									Swal.fire({
										text: response.data.msg,
										icon: "error",
										buttonsStyling: false,
										confirmButtonText: "Ok, got it!",
										customClass: { confirmButton: "btn btn-primary" }
									});
								}
							})
							.catch(function (error) {
								Swal.fire({
									text: "Sorry, looks like there are some errors detected, please try again.",
									icon: "error",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: { confirmButton: "btn btn-primary" }
								});
							})
							.then(function () {
								e.removeAttribute("data-kt-indicator");
								e.disabled = false;
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
			// Add this part to handle Enter key press
			t.addEventListener("keypress", function (event) {
				if (event.key === 'Enter') {
					if (document.activeElement !== e) {
						event.preventDefault();
						e.click();
					}
				}
			});
		}
	};
})();

var KTAuthVerifyOTP = (function () {
	var t, e, r;
	return {
		init: function () {
			t = document.querySelector("#kt_password_verify_reset_form");
			e = document.querySelector("#kt_password_verify_reset_submit");

			r = FormValidation.formValidation(t, {
				fields: {
					otp: {
						validators: {
							regexp: {
								regexp: /^[0-9]{6}$/,
								message: "The value is not a valid OTP"
							},
							notEmpty: {
								message: "OTP is required"
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
				}
			});

			e.addEventListener("click", function (i) {
				i.preventDefault();
				r.validate().then(function (status) {
					if (status === "Valid") {
						e.setAttribute("data-kt-indicator", "on");
						e.disabled = true;

						axios.post(t.getAttribute("action"), new FormData(t))
							.then(function (response) {
								if (response.data.res === 'success') {
									Swal.fire({
										text: response.data.msg,
										icon: "success",
										buttonsStyling: false,
										confirmButtonText: "Ok, got it!",
										customClass: { confirmButton: "btn btn-primary" }
									});
									window.location.href = response.data.redirect_url;
								} else {
									Swal.fire({
										text: response.data.msg,
										icon: "error",
										buttonsStyling: false,
										confirmButtonText: "Ok, got it!",
										customClass: { confirmButton: "btn btn-primary" }
									});
								}
							})
							.catch(function (error) {
								Swal.fire({
									text: "Sorry, looks like there are some errors detected, please try again.",
									icon: "error",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: { confirmButton: "btn btn-primary" }
								});
							})
							.then(function () {
								e.removeAttribute("data-kt-indicator");
								e.disabled = false;
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
			// Add this part to handle Enter key press
			t.addEventListener("keypress", function (event) {
				if (event.key === 'Enter') {
					if (document.activeElement !== e) {
						event.preventDefault();
						e.click();
					}
				}
			});
		}
	};
})();

KTUtil.onDOMContentLoaded(function () {
	KTAuthResetPassword.init();
	KTAuthVerifyOTP.init();
});
