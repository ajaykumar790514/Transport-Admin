"use strict";

var KTAppEcommerceReportSales = (function () {
    var table, dataTable;

    var initTable = function () {
        var tableElement = document.querySelector("#kt_ecommerce_wallet_table");
		document.getElementById('wallet_loader').style.display = 'block';
		document.getElementById('wallet_content').style.display = 'none';
		setTimeout(function() {
        if (tableElement) {
            dataTable = $(tableElement).DataTable({
                info: false,
                order: [],
                ajax: {
                    url: CI_ROOT + 'sellers/get_wallet', // Replace with your actual endpoint URL
                    type: 'GET',
                    data: function (d) {
                        d.search = document.querySelector('[data-kt-ecommerce-order-filter="search"]').value;
                        d.daterange = document.querySelector('#kt_ecommerce_wallet_daterangepicker').value;
                        d.seller_id = document.querySelector('#seller_id').value;
                    },
                    dataSrc: 'data',
					complete: function() {
						document.getElementById('wallet_loader').style.display = 'none';
						document.getElementById('wallet_content').style.display = 'block';
					}
                },
                columns: [
                    { data: 0 },
                    { data: 1 },
                    { data: 2 },
                    { data: 3 },
                    { data: 4 },
                ],
                columnDefs: [
                    { orderable: false, targets: 0 },
                    { orderable: false, targets: 4 }
                ]
            });

            document.querySelector('[data-kt-ecommerce-order-filter="search"]').addEventListener("keyup", function (e) {
                dataTable.search(e.target.value).draw();
            });

            document.querySelectorAll('[data-kt-ecommerce-filter]').forEach((filterElement) => {
                $(filterElement).on("change", (e) => {
                    dataTable.ajax.reload();
                });
            });
        }
	  },1000);
    };

    var initDateRangePicker = function () {
        var startDate = moment().startOf("day"); // Default start date is today
        var endDate = moment().endOf("day"); // Default end date is today
        var dateRangePicker = $("#kt_ecommerce_wallet_daterangepicker");

        function updateDateRangeDisplay(start, end) {
            dateRangePicker.html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
        }

        dateRangePicker.daterangepicker({
            startDate: startDate,
            endDate: endDate,
            ranges: {
                "Today": [moment(), moment()],
                "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "This Month": [moment().startOf("month"), moment().endOf("month")],
                "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
            }
        }, updateDateRangeDisplay);

        updateDateRangeDisplay(startDate, endDate);

        dateRangePicker.on('apply.daterangepicker', function(ev, picker) {
            dataTable.ajax.reload();
        });
    };

    var initExportButtons = function () {
        const exportTitle = "Sales Report";
        new $.fn.dataTable.Buttons(dataTable, {
            buttons: [
                { extend: "copyHtml5", title: exportTitle },
                { extend: "excelHtml5", title: exportTitle },
                { extend: "csvHtml5", title: exportTitle },
                { extend: "pdfHtml5", title: exportTitle }
            ]
        }).container().appendTo($("#kt_ecommerce_wallet_export"));

        document.querySelectorAll("#kt_ecommerce_wallet_export_menu [data-kt-ecommerce-export]").forEach((button) => {
            button.addEventListener("click", (e) => {
                e.preventDefault();
                const exportType = e.target.getAttribute("data-kt-ecommerce-export");
                document.querySelector(".dt-buttons .buttons-" + exportType).click();
            });
        });
    };

    return {
        init: function () {
            initTable();
            initDateRangePicker();
            initExportButtons();
        }
    };
})();

function load_wallet(content)
{
    if(content === 'wallet' && !KTAppEcommerceReportSales.isInitialized) {
		
        KTAppEcommerceReportSales.init();
        KTAppEcommerceReportSales.isInitialized = true;
    }
}

