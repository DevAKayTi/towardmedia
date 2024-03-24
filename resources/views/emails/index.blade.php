@section('css')
<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }

</style>
@endsection
@extends('layouts.backend.master')

@section('content')
<div class="content">
    <main id="">
        <!-- Dynamic Table Full -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title ">Emails (<span id="postCountDatatable">{{$allPosts}}</span>)</h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-striped table-borderless table-vcenter " id="emails-table">
                    <thead>
                        <tr class="bg-body-dark">
                            <th>#</th>
                            <th>Emails</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Emails</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection

@section('footer-scripts')

<script type="text/javascript">
    $(document).ready(function() {
        $('#emails-table tfoot th').each(function() {
            var title = $(this).text();
            if (title == 'No' || title == 'Action' || title == 'Created' || title == 'Published') {
                $(this).html('<input type="text" class=" form-control d-none" placeholder="Search ' + title + '" />');
            } else {
                $(this).html('<input type="text" class=" form-control" placeholder="Search ' + title + '" />');

            }
        });

        load_data();

        function load_data(from_date = '', to_date = '') {
            $('#emails-table').DataTable({
                "processing": true
                , "serverSide": true
                , pagingType: "full_numbers"
                , lengthMenu: [
                    [5, 10, 20]
                    , [5, 10, 20]
                ]
                , order: [
                    [1, "asc"]
                ]
                , autoWidth: false
                , initComplete: function() {
                    // Apply the search
                    this.api()
                        .columns()
                        .every(function() {
                            var that = this;
                            $('input', this.footer()).on('keyup change clear', function() {
                                if (that.search() !== this.value) {
                                    that.search(this.value).draw();
                                }
                            });
                        });
                }
                , ajax: {
                    url: '/admin/emails'
                    , data: {
                        from_date: from_date
                        , to_date: to_date
                    }
                    , complete: function({
                        responseJSON
                    }) {
                        let {
                            recordsTotal
                        } = responseJSON;
                        $('#postCountDatatable').text(recordsTotal)
                        $('#postCount').text(recordsTotal);
                    }
                }
                , columns: [{
                            data: 'DT_RowIndex'
                            , name: 'DT_RowIndex'
                            , orderable: false
                            , searchable: false
                        }
                        , {
                            data: 'email'
                            , name: 'email'
                        }, {
                            data: 'is_activated'
                            , name: 'is_activated'
                        }
                        , {
                            data: 'created_at'
                            , name: 'created_at'
                        }
                        , {
                            data: 'action'
                            , name: 'action'
                            , orderable: false
                            , searchable: false
                        }
                    ]

            , });
        }
        
        $(document).on('click', '.delete-email-btn', function() {

            swal({
                    title: "Are you sure?"
                    , text: "Once deleted, All new releases will not be sent"
                    , icon: "warning"
                    , buttons: true
                    , dangerMode: true
                , })
                .then((willDelete) => {
                    if (willDelete) {
                        if (emailId) {
                            Dashmix.loader('show', 'bg-primary')
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: '/admin/emails/' + emailId
                                , method: "Delete"
                                , dataType: "json"
                                , success: function(response) {
                                    if (response.success) {
                                        toastr.info(" ", "Record Deleted Successfully", {
                                            iconClass: "toast-custom"
                                        });

                                        $('#emails-table').DataTable().ajax.reload();
                                        swal("Email has been deleted!", {
                                            icon: "success"
                                        , });
                                    } else {
                                        if (response.error) {
                                            toastr.error(" ", response.error, {});
                                        }
                                    }
                                }
                                , complete: function() {
                                    Dashmix.loader('hide')
                                }
                            });
                        }
                    } else {
                        swal("Your Email  is safe!");
                    }
                });
            let emailId = $(this).data("id")

        });

        $(document).on('click', '.edit-email-btn', function() {

            swal({
                    title: "Are you sure?"
                    , text: "Do u want to change this email status."
                    , icon: "warning"
                    , buttons: true
                    , dangerMode: true
                , })
                .then((willDelete) => {
                    if (willDelete) {
                        if (emailId) {
                            Dashmix.loader('show', 'bg-primary')
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: '/admin/emails/' + emailId
                                , method: "PUT"
                                , dataType: "json"
                                , success: function(response) {
                                    if (response.success) {
                                        toastr.info(" ", "Record Updated Successfully", {
                                            iconClass: "toast-custom"
                                        });

                                        $('#emails-table').DataTable().ajax.reload();
                                        swal("Email has been updated!", {
                                            icon: "success"
                                        , });
                                    } else {
                                        if (response.error) {
                                            toastr.error(" ", response.error, {});
                                        }
                                    }
                                }
                                , complete: function() {
                                    Dashmix.loader('hide')
                                }
                            });
                        }
                    }
                });
            let emailId = $(this).data("id")
        });

        $('.dataTables_filter input[type="search"]').css({
            'width': '400px'
            , 'display': 'none'
        });
    });

</script>
@endsection