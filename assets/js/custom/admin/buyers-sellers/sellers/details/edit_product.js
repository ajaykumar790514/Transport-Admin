"use strict";
var KTAppEcommerceSaveProduct = (function () {
    const e = () => {
            $("#kt_ecommerce_add_product_options").repeater({
                initEmpty: !1,
                defaultValues: { "text-input": "foo" },
                show: function () {
                    $(this).slideDown(), t();
                },
                hide: function (e) {
                    $(this).slideUp(e);
                },
            });
        },
        t = () => {
            document.querySelectorAll('[data-kt-ecommerce-catalog-add-product="product_option"]').forEach((e) => {
                $(e).hasClass("select2-hidden-accessible") || $(e).select2({ minimumResultsForSearch: -1 });
            });
        };

		const checkDuplicateProductName = () => {
			const productNameField = document.querySelector('[name="product_name"]');
			const submitButton = document.getElementById('kt_ecommerce_add_product_submit');
			productNameField.addEventListener('change', () => {
				const productName = productNameField.value;
				$.ajax({
					url: CI_ROOT + 'sellers/check_product_name',
					method: 'POST',
					data: { product_name: productName },
					dataType: 'json',
					success: function(response) {
						if (response.exists) {
							$('#product_name_error').html('<span class="text-danger">The product name is already in use</span>');
							Swal.fire({
								text: "The product name is already in use",
								icon: "error",
								buttonsStyling: !1,
								confirmButtonText: "Ok, got it!",
								customClass: { confirmButton: "btn btn-primary" },
							});
							submitButton.disabled = true; // Disable submit button
						} else {
							$('#product_name_error').html(''); // Clear error message
							submitButton.disabled = false; // Enable submit button
						}
					},
					error: function() {
						$('#product_name_error').html('<span class="text-danger">Error checking product name</span>');
						submitButton.disabled = true; // Disable submit button on error
					}
				});
			});
		};

    return {
        init: function () {
            var o, a;
            ["#kt_ecommerce_add_product_description", "#kt_ecommerce_add_product_meta_description"].forEach((e) => {
                let t = document.querySelector(e);
                t && (t = new Quill(e, { modules: { toolbar: [[{ header: [1, 2, !1] }], ["bold", "italic", "underline"], ["image", "code-block"]] }, placeholder: "Type your text here...", theme: "snow" }));
            }),
                ["#kt_ecommerce_add_product_category"].forEach((e) => {
                    const t = document.querySelector(e);
                    t && new Tagify(t, { whitelist: ["new", "trending", "sale", "discounted", "selling fast", "last 10"], dropdown: { maxItems: 20, classname: "tagify__inline__suggestions", enabled: 0, closeOnSelect: !1 } });
                }),
                e(),
                t(),
                checkDuplicateProductName(),
                (() => {
                    const e = document.getElementById("kt_ecommerce_add_product_status"),
                        t = document.getElementById("kt_ecommerce_add_product_status_select"),
                        o = ["bg-success", "bg-warning", "bg-danger"];
                    $(t).on("change", function (t) {
                        switch (t.target.value) {
                            case "1":
                                e.classList.remove(...o), e.classList.add("bg-success"), c();
                                break;
                            case "scheduled":
                                e.classList.remove(...o), e.classList.add("bg-warning"), d();
                                break;
                            case "0":
                                e.classList.remove(...o), e.classList.add("bg-danger"), c();
                                break;
                            case "draft":
                                e.classList.remove(...o), e.classList.add("bg-primary"), c();
                        }
                    });
                    const a = document.getElementById("kt_ecommerce_add_product_status_datepicker");
                    $("#kt_ecommerce_add_product_status_datepicker").flatpickr({ enableTime: !0, dateFormat: "Y-m-d H:i" });
                    const d = () => {
                            a.parentNode.classList.remove("d-none");
                        },
                        c = () => {
                            a.parentNode.classList.add("d-none");
                        };
                })(),
                (() => {
                    const e = document.querySelectorAll('[name="method"][type="radio"]'),
                        t = document.querySelector('[data-kt-ecommerce-catalog-add-category="auto-options"]');
                    e.forEach((e) => {
                        e.addEventListener("change", (e) => {
                            "1" === e.target.value ? t.classList.remove("d-none") : t.classList.add("d-none");
                        });
                    });
                })(),
                (() => {
                    const e = document.querySelectorAll('input[name="discount_option"]'),
                        t = document.getElementById("kt_ecommerce_add_product_discount_percentage"),
                        o = document.getElementById("kt_ecommerce_add_product_discount_fixed");
                    e.forEach((e) => {
                        e.addEventListener("change", (e) => {
                            switch (e.target.value) {
                                case "2":
                                    t.classList.remove("d-none"), o.classList.add("d-none");
                                    break;
                                case "3":
                                    t.classList.add("d-none"), o.classList.remove("d-none");
                                    break;
                                default:
                                    t.classList.add("d-none"), o.classList.add("d-none");
                            }
                        });
                    });
                })(),
              
                (() => {
                    let e;
                    const t = document.getElementById("kt_ecommerce_add_product_form"),
                        o = document.getElementById("kt_ecommerce_add_product_submit");
                        (e = FormValidation.formValidation(t, {
                            fields: {
                                product_name: { 
                                    validators: { 
                                        notEmpty: { message: "Product name is required" },
                                        remote: {
                                            message: 'The product name is already in use',
                                            method: 'POST',
                                            url: CI_ROOT+'sellers/check_product_name',
                                            data: function(validator, $field, value) {
                                                return {
                                                    product_name: $field.val()
                                                };
                                            }
                                        }
                                    } 
                                },
                                product_sku: { validators: { notEmpty: { message: "SKU is required" } } },
                                img: { validators: { notEmpty: { message: "Image is required" } } },
                                price: { validators: { notEmpty: { message: "Product base price is required" } } },
                                price_unit: { validators: { notEmpty: { message: "Product base price unit is required" } } },
                                qty: { validators: { notEmpty: { message: "Product base qty is required" } } },
                                qty_unit: { validators: { notEmpty: { message: "Product qty unit is required" } } },
                                cat_id: { validators: { notEmpty: { message: "Product category is required" } } },
								keywords: { validators: { notEmpty: { message: "Product keywords is required" } } },
                            },
                            plugins: { 
                                trigger: new FormValidation.plugins.Trigger(), 
                                bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" }) 
                            },
                        })),
                        o.addEventListener("click", (a) => {
                            a.preventDefault(),
                                e &&
                                    e.validate().then(function (e) {
                                        console.log("validated!"),
                                            "Valid" == e
                                                ? (o.setAttribute("data-kt-indicator", "on"),
                                                  (o.disabled = !0),
                                                  setTimeout(function () {
                                                      o.removeAttribute("data-kt-indicator");
                                                      o.disabled = !1;
                                                      // AJAX request to add product
                                                      var formData = new FormData(t);
                                                      var quill = Quill.find(document.querySelector("#kt_ecommerce_add_product_description"));
                                                      formData.append('description', quill.root.innerHTML);
                                                      $.ajax({
                                                          url: $(t).attr("action"),
                                                          type: 'POST',
                                                          data: formData,
                                                          processData: false,
                                                          contentType: false,
                                                          dataType: 'json',
                                                          success: function (response) {
                                                              if (response.res==="success") {
                                                                  Swal.fire({
                                                                      text: response.msg,
                                                                      icon: "success",
                                                                      buttonsStyling: false,
                                                                      confirmButtonText: "Ok, got it!",
                                                                      customClass: { confirmButton: "btn btn-primary" }
                                                                  }).then(function() {
																	window.location = response.url;
                                                                  });
                                                              } else {
                                                                  Swal.fire({
                                                                      text: response.msg,
                                                                      icon: "error",
                                                                      buttonsStyling: false,
                                                                      confirmButtonText: "Ok, got it!",
                                                                      customClass: { confirmButton: "btn btn-primary" }
                                                                  });
                                                              }
                                                          },
                                                          error: function (xhr, status, error) {
                                                              console.error('Error adding product:', error);
                                                              Swal.fire({
                                                                  text: "Sorry, there was an error adding your product. Please try again.",
                                                                  icon: "error",
                                                                  buttonsStyling: false,
                                                                  confirmButtonText: "Ok, got it!",
                                                                  customClass: { confirmButton: "btn btn-primary" }
                                                              });
                                                          }
                                                      });
                                                  }, 2000))
                                                : Swal.fire({
                                                      html:
                                                          "Sorry, looks like there are some errors detected, please try again. <br/><br/>Please note that there may be errors in the <strong>General</strong>",
                                                      icon: "error",
                                                      buttonsStyling: !1,
                                                      confirmButtonText: "Ok, got it!",
                                                      customClass: { confirmButton: "btn btn-primary" },
                                                  });
                                    });
                        });
                })();
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTAppEcommerceSaveProduct.init();
});


function checkFileSize() {
	var files = $('#productImage')[0].files;
	var maxSize = 100 * 1024;
	var submitButton = $('#kt_ecommerce_add_product_submit');

	for (var i = 0; i < files.length; i++) {
		if (files[i].size > maxSize) {
			alert_toastr("error", "Product image should be less than 100 KB.");
			submitButton.prop('disabled', true);
			$('#productImage').val('');
			return;
		}
	}
	submitButton.prop('disabled', false);
	updateImagePreview(files[0]); // Update the image preview
}

function updateImagePreview(file) {
	var reader = new FileReader();
	reader.onload = function(e) {
		$('.image-input-wrapper').css('background-image', 'url(' + e.target.result + ')');
	};
	reader.readAsDataURL(file);
}

$('#productImage').on('change', checkFileSize);

function select_parent_cat(btn, cat_id1, cat_id2){
    $('#defaultCheck'+cat_id1).prop('checked', true);
    $('#defaultCheck'+cat_id2).prop('checked', true);
}
