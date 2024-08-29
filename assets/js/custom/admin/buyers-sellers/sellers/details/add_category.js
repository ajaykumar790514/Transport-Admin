"use strict";
var remoteurl = $('#remote').val();
$(".needs-validation").validate({
    rules: {
        name: {
            required: true,
            remote: remoteurl + "null/name"
        },
        description: "required",
        // icon: "required"
    },
    messages: {
        name: {
            remote: "Category already exists!"
        },
        description: "Please Enter Description!",
        icon: "Please Select Image!"
    },
    errorElement: "span",
    errorClass: "error",
    highlight: function(element) {
        $(element).addClass("error");
    },
    unhighlight: function(element) {
        $(element).removeClass("error");
    },
    errorPlacement: function(error, element) {
        error.insertAfter(element); 
    }
});

const e = document.getElementById("kt_ecommerce_add_category_status"),
 t = document.getElementById("kt_ecommerce_add_category_status_select"),
o = ["bg-success", "bg-warning", "bg-danger"];
$(t).on("change", function (t) {
switch (t.target.value) {
	case "published":
		e.classList.remove(...o), e.classList.add("bg-success"), r();
		break;
	case "scheduled":
		e.classList.remove(...o), e.classList.add("bg-warning"), c();
		break;
	case "unpublished":
		e.classList.remove(...o), e.classList.add("bg-danger"), r();
}
});

$(document).on("submit", '.categorysubmit', function(event) {
    event.preventDefault();
    var $this = $(this); // Define $this here
    if ($this.hasClass("append")) {
        var append_data = $($this.attr('append-data')).val();
        $this.append('<input type="hidden" name="append" value="' + append_data + '" /> ');
    }
    var form_data = new FormData(this);
    var form_valid = true;

    if ($this.hasClass("validate-form")) {
        if ($this.valid()) {
            form_valid = true;
        } else {
            form_valid = false;
        }
    }

    setTimeout(function() {
        if (form_valid) {
            $.ajax({
                url: $this.attr("action"),
                type: $this.attr("method"),
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    data = JSON.parse(data);
                    if (data.res == 'success') {
                        setTimeout(function() {
                            Swal.fire({
                                text: data.msg,
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: { confirmButton: "btn btn-primary" },
                            }).then(function(e) {
                                window.location = data.url;
                            });
                        }, 500);
                    } else {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: { confirmButton: "btn btn-primary" },
                        });
                    }
                    if (data.errors) {
                        $.each(data.errors, function(key, value) {
                            $this.find(`[name="${key}"]`).parents(`.form-group`).find(`.error`).text(value);
                        });
                    }
                }
            });
        }
    }, 100);

    return false;
});

// Function to check file size on image input change
function checkFileSize() {
    var files = $('#categoryImage')[0].files;
    var maxSize = 200 * 1024;
    var submitButton = $('#kt_ecommerce_add_category_submit');

    for (var i = 0; i < files.length; i++) {
        if (files[i].size > maxSize) {
            alert_toastr("error", "Category image should be less than 200 KB.");
            submitButton.prop('disabled', true);
            $('#categoryImage').val('');
            return;
        }
    }
    submitButton.prop('disabled', false);
}

// Event listener for image input change
$('#categoryImage').on('change', checkFileSize);

// Function to fetch sub-categories via AJAX
function fetch_sub_categories(parent_id) {
    $.ajax({
        url: CI_ROOT + "buyers-sellers/fetch_sub_categories",
        method: "POST",
        data: {
            parent_id: parent_id,
            consumer_id: $('#consumer_id').val(),
        },
        success: function(data) {
            $(".sub_cat_id").html(data);
        }
    });
}
