
"use strict";
var KTProductsList = (function () {
    var t, e,
        o = () => {
            e.querySelectorAll('[data-kt-product-table-filter="delete_row"]').forEach((deleteBtn) => {
                deleteBtn.addEventListener("click", function (e) {
                    e.preventDefault();
                    const row = e.target.closest("tr"),
                        name = row.querySelectorAll("td")[2].innerText; // Adjusted index for 'name'
                    Swal.fire({
                        text: "Are you sure you want to delete " + name + "?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: { confirmButton: "btn fw-bold btn-danger", cancelButton: "btn fw-bold btn-active-light-primary" },
                    }).then(function (result) {
                        if (result.value) {
                            const $this = $(deleteBtn);
                            const url = $this.attr('url');
                            $.post(url, function (data) {
                                data = JSON.parse(data);
                                if (data.res == 'success') {
                                    $this.closest('tr').remove();
                                    Swal.fire({
                                        text: "You have deleted " + name + "!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: { confirmButton: "btn fw-bold btn-primary" }
                                    });
                                } else {
                                    Swal.fire({
                                        text: "Failed to delete " + name + "!",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: { confirmButton: "btn fw-bold btn-primary" }
                                    });
                                }
                                alert_toastr(data.res, data.msg);
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire({
                                text: name + " was not deleted.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: { confirmButton: "btn fw-bold btn-primary" }
                            });
                        }
                    });
                });
            });
        },
        n = () => {
            const checkboxes = e.querySelectorAll('[type="checkbox"]'),
                deleteSelectedBtn = document.querySelector('[data-kt-product-table-select="delete_selected"]');
            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener("click", function () {
                    setTimeout(function () {
                        c();
                    }, 50);
                });
            }),
                deleteSelectedBtn.addEventListener("click", function () {
                    const selectedIds = [];
                    checkboxes.forEach((checkbox) => {
                        if (checkbox.checked) {
                            selectedIds.push($(checkbox).val()); // Assuming each checkbox has a value attribute with the user ID
                        }
                    });

                    if (selectedIds.length === 0) {
                        Swal.fire({
                            text: "Please select at least one user to delete.",
                            icon: "warning",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: { confirmButton: "btn fw-bold btn-primary" }
                        });
                        return;
                    }

                    Swal.fire({
                        text: "Are you sure you want to delete selected product?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: { confirmButton: "btn fw-bold btn-danger", cancelButton: "btn fw-bold btn-active-light-primary" },
                    }).then(function (result) {
                        if (result.value) {
                            $.ajax({
                                type: "POST",
                                url: CI_ROOT + 'sellers/delete_selected_product', // Replace with your actual endpoint URL to handle multiple deletions
                                data: { ids: selectedIds },
                                success: function (data) {
                                    data = JSON.parse(data);
                                    if (data.res == 'success') {
                                        Swal.fire({
                                            text: "You have deleted selected product!.",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: { confirmButton: "btn fw-bold btn-primary" }
                                        }).then(function () {
                                            // Remove selected rows from DataTable
                                            checkboxes.forEach((checkbox) => {
                                                if (checkbox.checked) {
                                                    t.row($(checkbox.closest("tbody tr"))).remove();
                                                }
                                            });
                                            t.draw(false); // Redraw DataTable without refreshing data
                                        });
                                    } else {
                                        Swal.fire({
                                            text: "Failed to delete selected category!.",
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: { confirmButton: "btn fw-bold btn-primary" }
                                        });
                                    }
                                    alert_toastr(data.res, data.msg);
                                },
                                error: function () {
                                    Swal.fire({
                                        text: "Error occurred while processing your request.",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: { confirmButton: "btn fw-bold btn-primary" }
                                    });
                                }
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire({
                                text: "Selected users were not deleted.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: { confirmButton: "btn fw-bold btn-primary" }
                            });
                        }
                    });
                });
        };
    const c = () => {
        const baseToolbar = document.querySelector('[data-kt-product-table-toolbar="base"]'),
            selectedToolbar = document.querySelector('[data-kt-product-table-toolbar="selected"]'),
            selectedCount = document.querySelector('[data-kt-product-table-select="selected_count"]'),
            checkboxes = e.querySelectorAll('tbody [type="checkbox"]');
        let anyChecked = false,
            count = 0;
        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                anyChecked = true;
                count++;
            }
        });
        if (anyChecked) {
            selectedCount.innerHTML = count;
            baseToolbar.classList.add("d-none");
            selectedToolbar.classList.remove("d-none");
        } else {
            baseToolbar.classList.remove("d-none");
            selectedToolbar.classList.add("d-none");
        }
    };
    return {
        init: function () {
            e = document.querySelector("#kt_product_table");
			console.log(e);
            if (e) {
                e.querySelectorAll("tbody tr").forEach((row) => {
                    const cells = row.querySelectorAll("td"),
                        date = moment(cells[5].innerHTML, "DD MMM YYYY, LT").format();
                    cells[5].setAttribute("data-order", date);
                });
				document.getElementById('product_loader').style.display = 'block';
                document.getElementById('product_content').style.display = 'none';
				setTimeout(function() {
				t = $(e).DataTable({
                    info: false,
                    order: [],
                    ajax: {
                        url: CI_ROOT + 'sellers/get_product', // Replace with your actual endpoint URL
                        type: 'GET',
						data: function(d) {
                            d.consumer_id = document.querySelector('#consumer_id').value;
							d.search = document.querySelector('[data-kt-product-table-filter="search"]').value;
							d.parent_cat = document.querySelector('[data-kt-product-filter="parent_category"]').value;
							d.sub_cat = document.querySelector('[data-kt-product-filter="sub_category"]').value;
							d.category = document.querySelector('[data-kt-product-filter="category"]').value;
                        },
                        dataSrc: 'data',
						complete: function() {
                            document.getElementById('product_loader').style.display = 'none';
                            document.getElementById('product_content').style.display = 'block';
                        }
                    },
                    columns: [
                        { data: null, orderable: false,
							render: function (data, type, row) {
								return '<div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" value="' + data[9] + '" /></div>';
							  } 
					    },
                        { data: 0 },
                        { data: 1 },
                        { data: 2 },
						{ data: 3 },
						{ data: 4 },
                        { data: 5 },
                        { data: 6 },
                        { data: 7 },
						{ data: 8 },
						
                    ],
                    columnDefs: [
                        { orderable: false, targets: 0 },
                        { orderable: false, targets: 8 },
                    ],
                }).on("draw", function () {
                    n();
                    o();
                    c();
                });
			},1000);
                const searchFilter = document.querySelector('[data-kt-product-table-filter="search"]');
                $(searchFilter).on("change", (e) => {
                    t.ajax.reload();
                });
				const parent_categoryFilter = document.querySelector('[data-kt-product-filter="parent_category"]');
                $(parent_categoryFilter).on("change", (e) => {
                    t.ajax.reload();
                });
				const sub_categoryFilter = document.querySelector('[data-kt-product-filter="sub_category"]');
                $(sub_categoryFilter).on("change", (e) => {
                    t.ajax.reload();
                });
				const categoryFilter = document.querySelector('[data-kt-product-filter="category"]');
                $(categoryFilter).on("change", (e) => {
                    t.ajax.reload();
                });
                o();
            }
        },
    };
})();


function load_product(content)
{
    if(content === 'product' &&  !KTProductsList.isInitialized)
    {
        KTProductsList.init();
        KTProductsList.isInitialized = true;
    }
}





function fetch_sub_categories(parent_id)
{
 $.ajax({
	 url: CI_ROOT+"buyers-sellers/fetch_sub_categories",
	 method: "POST",
	 data: {
		 parent_id:parent_id,
		 consumer_id:$('#consumer_id').val(),
	 },
	 success: function(data){
		 $(".sub_cat_id").html(data);
	 },
 });
}
function fetch_categories(parent_id)
{
 $.ajax({
	 url: CI_ROOT+"buyers-sellers/fetch_categories",
	 method: "POST",
	 data: {
		 parent_id:parent_id,
		 consumer_id:$('#consumer_id').val(),
	 },
	 success: function(data){
		 $(".cat_id").html(data);
	 },
 });
}





   function checkFileSize() {
	 var files = $('#categoryImage')[0].files;
	 var maxSize = 200 * 1024;
	 var submitButton = $('#btnsubmit');
	 
	 for (var i = 0; i < files.length; i++) {
		 if (files[i].size > maxSize) {
			 alert_toastr("error","Category image should be less than 200 KB.");
			 submitButton.prop('disabled', true);
			  $('#categoryImage').val('');
			 return;
		 }
	 }
	 submitButton.prop('disabled', false);
 }
 $('#categoryImage').on('change', checkFileSize);

