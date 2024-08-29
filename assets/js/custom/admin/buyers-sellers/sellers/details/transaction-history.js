"use strict";

var KTCustomerViewPaymentTable = (function () {
    var t,
        e = document.querySelector("#kt_table_customers_payment");

    return {
        init: function () {
            if (e) {
                e.querySelectorAll("tbody tr").forEach((row) => {
                    const cells = row.querySelectorAll("td"),
                        date = moment(cells[3].innerHTML, "DD MMM YYYY, LT").format();
                    cells[3].setAttribute("data-order", date);
                });

                t = $(e).DataTable({
                    info: false,
                    order: [],
                    ajax: {
                        url: CI_ROOT + 'sellers/get_history', // Replace with your actual endpoint URL
                        type: 'GET',
                        data: function(d) {
                            d.start_date = document.querySelector('#start_date').value;
                            d.end_date = document.querySelector('#end_date').value;
                            d.consumer_id = document.querySelector('#consumer_id').value;
                            d.status = document.querySelector('[data-kt-payment-filter="status"]').value;
                        },
                        dataSrc: 'data'
                    },
                    columns: [
                        { data: 0 },
                        { data: 1 },
                        { data: 2 },
                        { data: 3 }
                    ],
                    columnDefs: [
                        { orderable: false, targets: [0, 3] } // Disable ordering on first and last column
                    ]
                }).on("draw", function () {
                    // n();
                    // o();
                    // c();
                });

                // Date range filter reload
                $('#start_date, #end_date').on('change', function() {
                    t.ajax.reload();
                });

                // Status filter reload
                const statusFilter = document.querySelector('[data-kt-payment-filter="status"]');
                $(statusFilter).on("change", (e) => {
                    t.ajax.reload();
                });

                // Delete row functionality
                e.querySelectorAll('[data-kt-customer-table-filter="delete_row"]').forEach((button) => {
                    button.addEventListener("click", function (e) {
                        e.preventDefault();
                        const row = e.target.closest("tr"),
                            orderNo = row.querySelectorAll("td")[0].innerText;

                        Swal.fire({
                            text: "Are you sure you want to delete order " + orderNo + "?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            },
                        }).then(function (result) {
                            if (result.value) {
                                Swal.fire({
                                    text: "You have deleted order " + orderNo + "!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: { confirmButton: "btn fw-bold btn-primary" }
                                }).then(function () {
                                    t.row($(row)).remove().draw();
                                }).then(function () {
                                    toggleToolbars();
                                });
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                Swal.fire({
                                    text: "Order " + orderNo + " was not deleted.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: { confirmButton: "btn fw-bold btn-primary" }
                                });
                            }
                        });
                    });
                });
            }
        }
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTCustomerViewPaymentTable.init();
});


function load_general(content)
{

	if(content=='general' )
		{
				document.getElementById('general_loader').style.display = 'block';
				document.getElementById('general_content').style.display = 'none';
				setTimeout(function() {
					document.getElementById('general_loader').style.display = 'none';
					document.getElementById('general_content').style.display = 'block';
				}, 1000);
		}
}

   

function fetchTotalRupee() {
	var startDate = $('#start_date').val();
	var endDate = $('#end_date').val();

	$.ajax({
		url: CI_ROOT + 'sellers/get_total_rupee', 
		type: 'GET',
		data: {
			start_date: startDate,
			end_date: endDate
		},
		dataType: 'json',
		success: function(response) {
			$('#total-rupee').text(response.total_rupee);
		},
		error: function(xhr, status, error) {
			console.error('Error fetching total rupee:', error);
		}
	});
}

var currentDate = new Date().toISOString().split('T')[0];
$('#start_date').val(currentDate);
$('#end_date').val(currentDate);

$('#start_date, #end_date').on('change', fetchTotalRupee);

// Trigger the function on page load
fetchTotalRupee();


