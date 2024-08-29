"use strict";

var KTAppEcommerceProducts = (function () {
    var t,
        e,
        n,
        r = () => {
            e.querySelectorAll('[data-kt-ecommerce-product-filter="delete_row"]').forEach((t) => {
                t.addEventListener("click", function (t) {
                    t.preventDefault();
                    const e = t.target.closest("tr"),
                        r = e.querySelector('[data-kt-ecommerce-product-filter="product_name"]').innerText;
                    Swal.fire({
                        text: "Are you sure you want to delete " + r + "?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: { confirmButton: "btn fw-bold btn-danger", cancelButton: "btn fw-bold btn-active-light-primary" },
                    }).then(function (t) {
                        t.value
                            ? Swal.fire({ text: "You have deleted " + r + "!.", icon: "success", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn fw-bold btn-primary" } }).then(function () {
                                  n.row($(e)).remove().draw();
                              })
                            : "cancel" === t.dismiss && Swal.fire({ text: r + " was not deleted.", icon: "error", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn fw-bold btn-primary" } });
                    });
                });
            });
        };
    return {
        init: function () {
            t = "#kt_ecommerce_products_table";
            e = document.querySelector(t);
            n = new DataTable(t, {
                info: !1,
                order: [],
                pageLength: 10,
                ajax: {
                    url: 'your-ajax-endpoint-url', // Replace with your AJAX endpoint URL
                    type: 'GET',
                    dataSrc: ''
                },
                columns: [
                    { data: null, defaultContent: '<input type="checkbox" />', orderable: false },
                    { data: 's_no' },
                    { data: 'photo', render: function(data) { return '<img src="' + data + '" alt="Photo" />'; } },
                    { data: 'name' },
                    { data: 'username' },
                    { data: 'mobile' },
                    { data: 'email' },
                    { data: 'status' },
                    { data: null, defaultContent: '<button class="btn btn-sm btn-danger" data-kt-ecommerce-product-filter="delete_row">Delete</button>', orderable: false }
                ],
                columnDefs: [
                    { orderable: false, targets: 0 },
                    { orderable: false, targets: 8 }
                ],
            }).on("draw", function () {
                r();
            });

            document.querySelector('[data-kt-ecommerce-product-filter="search"]').addEventListener("keyup", function (t) {
                n.search(t.target.value).draw();
            });

            (() => {
                const t = document.querySelector('[data-kt-ecommerce-product-filter="status"]');
                $(t).on("change", (t) => {
                    let e = t.target.value;
                    "all" === e && (e = ""), n.column(6).search(e).draw();
                });
            })();

            r();
        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTAppEcommerceProducts.init();
});