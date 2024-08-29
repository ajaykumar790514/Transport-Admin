"use strict";
var KTCustomersList = (function () {
    var t,
        e,
		o = () => {
            e.querySelectorAll('[data-kt-role-table-filter="delete_row"]').forEach((deleteBtn) => {
                deleteBtn.addEventListener("click", function (e) {
                    e.preventDefault();
                    const row = e.target.closest("tr"),
                        name = row.querySelectorAll("td")[2].innerText; // Adjust this index based on your actual column index for 'name'
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
                deleteSelectedBtn = document.querySelector('[data-kt-role-table-select="delete_selected"]');
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
                            text: "Please select at least one roles to delete.",
                            icon: "warning",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: { confirmButton: "btn fw-bold btn-primary" }
                        });
                        return;
                    }

                    Swal.fire({
                        text: "Are you sure you want to delete selected roles?",
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
                                url: CI_ROOT + 'user-role/delete_selected', // Replace with your actual endpoint URL to handle multiple deletions
                                data: { ids: selectedIds },
                                success: function (data) {
                                    data = JSON.parse(data);
                                    if (data.res == 'success') {
                                        Swal.fire({
                                            text: "You have deleted selected users!.",
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
                                            text: "Failed to delete selected users!.",
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
                                text: "Selected roles were not deleted.",
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
        const t = document.querySelector('[data-kt-role-table-toolbar="base"]'),
            o = document.querySelector('[data-kt-role-table-toolbar="selected"]'),
            n = document.querySelector('[data-kt-role-table-select="selected_count"]'),
            c = e.querySelectorAll('tbody [type="checkbox"]');
        let r = !1,
            l = 0;
        c.forEach((t) => {
            t.checked && ((r = !0), l++);
        }),
            r ? ((n.innerHTML = l), t.classList.add("d-none"), o.classList.remove("d-none")) : (t.classList.remove("d-none"), o.classList.add("d-none"));
    };
    return {
        init: function () {
            (e = document.querySelector("#kt_roles_table")) &&
                (e.querySelectorAll("tbody tr").forEach((t) => {
                    const e = t.querySelectorAll("td"),
                        o = moment(e[5].innerHTML, "DD MMM YYYY, LT").format();
                    e[5].setAttribute("data-order", o);
                }),
                (t = $(e).DataTable({
                    info: !1,
                    order: [],
					ajax: {
                        url: CI_ROOT+'user-role/get_user_role', // Replace with your actual endpoint URL
                        type: 'GET',
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
                        { orderable: !1, targets: 0 },
                        { orderable: !1, targets: 5 },
                    ],
                })).on("draw", function () {
                    n(), o(), c();
                }),
                n(),
                document.querySelector('[data-kt-role-table-filter="search"]').addEventListener("keyup", function (e) {
                    t.search(e.target.value).draw();
                }),
                o(),
                (() => {
                    const e = document.querySelector('[data-kt-ecommerce-order-filter="status"]');
                    $(e).on("change", (e) => {
                        let o = e.target.value;
                        "all" === o && (o = ""), t.column(3).search(o).draw();
                    });
                })());
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTCustomersList.init();
});
