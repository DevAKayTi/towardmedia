$(document).ready(function () {
    $('.dropify').dropify();

    // customizing datatable
    jQuery.extend(jQuery.fn.dataTable.ext.classes, {
        sWrapper: "dataTables_wrapper dt-bootstrap5",
        sFilterInput: "form-control",
        sLengthSelect: "form-select",
    })
    jQuery.extend(true, jQuery.fn.dataTable.defaults, {
        language: {
            lengthMenu: "_MENU_"
            , search: "_INPUT_"
            , searchPlaceholder: "Search.."
            , info: "Page <strong>_PAGE_</strong> of <strong>_PAGES_</strong>"
            , paginate: {
                first: '<i class="fa fa-angle-double-left"></i>'
                , previous: '<i class="fa fa-angle-left"></i>'
                , next: '<i class="fa fa-angle-right"></i>'
                , last: '<i class="fa fa-angle-double-right"></i>'
            }
        }
    });
    jQuery.extend(!0, jQuery.fn.DataTable.Buttons.defaults, {
        dom: { button: { className: "btn btn-sm btn-primary" } },
    });


    //  date range initialization
    $('.input-daterange').datepicker({
        todayBtn: 'linked'
        , format: 'yyyy-mm-dd'
        , autoclose: true
    });

});