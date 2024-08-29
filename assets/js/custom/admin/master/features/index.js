"use strict";
var KTDailyItemsList = (function () {
    var t, e,
        o = () => {
            e.querySelectorAll('[data-kt-features-table-filter="delete_row"]').forEach((deleteBtn) => {
                deleteBtn.addEventListener("click", function (e) {
                    e.preventDefault();
                    const row = e.target.closest("tr"),
                        name = row.querySelectorAll("td")[3].innerText; // Adjust this index based on your actual column index for 'name'
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
            deleteSelectedBtn = document.querySelector('[data-kt-features-table-select="delete_selected"]');
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
                            text: "Please select at least one items to delete.",
                            icon: "warning",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: { confirmButton: "btn fw-bold btn-primary" }
                        });
                        return;
                    }

                    Swal.fire({
                        text: "Are you sure you want to delete selected features?",
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
                                url: CI_ROOT + 'features-master/delete_selected', // Replace with your actual endpoint URL to handle multiple deletions
                                data: { ids: selectedIds },
                                success: function (data) {
                                    data = JSON.parse(data);
                                    if (data.res == 'success') {
                                        Swal.fire({
                                            text: "You have deleted selected features!.",
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
                                            text: "Failed to delete selected features!.",
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
                                text: "Selected features were not deleted.",
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
        const baseToolbar = document.querySelector('[data-kt-features-table-toolbar="base"]'),
            selectedToolbar = document.querySelector('[data-kt-features-table-toolbar="selected"]'),
            selectedCount = document.querySelector('[data-kt-features-table-select="selected_count"]'),
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
            e = document.querySelector("#kt_features_table");
            if (e) {
                e.querySelectorAll("tbody tr").forEach((row) => {
                    const cells = row.querySelectorAll("td"),
                        date = moment(cells[5].innerHTML, "DD MMM YYYY, LT").format();
                    cells[5].setAttribute("data-order", date);
                });
                t = $(e).DataTable({
                    info: false,
                    order: [],
                    ajax: {
                        url: CI_ROOT + 'features-master/get_features', 
                        type: 'GET',
						data: function(d) {
							d.search = document.querySelector('[data-kt-features-table-filter="search"]').value;
                        },
                        dataSrc: 'data'
                    },
                    columns: [
                        { data: null, orderable: false,
							render: function (data, type, row) {
								return '<div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" value="' + data[6] + '" /></div>';
							  } 
					    },
                        { data: 0 },
                        { data: 1 },
                        { data: 2 },
                        { data: 3 },
                        { data: 4 },
						{ data: 5 },
                    ],
                    columnDefs: [
                        { orderable: false, targets: 0 },
                        { orderable: false, targets: 4 },
                    ],
                }).on("draw", function () {
                    n();
                    o();
                    c();
                });
                document.querySelector('[data-kt-features-table-filter="search"]').addEventListener("keyup", function (e) {
                    t.search(e.target.value).draw();
                });
                o();
				(() => {
					const searchFilter = document.querySelector('[data-kt-features-table-filter="search"]');
                    $(searchFilter).on("change", (e) => {
                        t.ajax.reload();
                    });
                })();
            }
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTDailyItemsList.init();
});
