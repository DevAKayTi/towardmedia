@extends('layouts.backend.master')
@section('content')
<div class="content">
    <main>
        <!-- Dynamic Table Full -->

        <div class="block block-rounded">
            <div class="block-header block-header-default d-flex justify-content-center align-items-center">
                <h3 class="block-title ">Posts (<span id="bulletinsCount">{{$bulletinsCount}}</span>)</h3>
                <a class="btn btn-block btn-primary " href="{{route('bulletins.create')}}">Create</a>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-striped table-borderless table-vcenter " id="bulletins-table">
                    <thead>
                        <tr class="bg-body-dark">
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Created</th>
                            <th>Published</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Created</th>
                            <th>Published</th>
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
<script>
    $(document).ready(function() {
        $('#bulletins-table tfoot th').each(function() {
            var title = $(this).text();
            if (title == '#' || title == 'Action' || title == 'Created' || title == 'Published') {
                $(this).html('<input type="text" class=" form-control d-none" placeholder="Search ' + title + '" />');
            } else {
                $(this).html('<input type="text" class=" form-control" placeholder="Search ' + title + '" />');

            }
        });

        load_data();

        function load_data(from_date = '', to_date = '') {
            $('#bulletins-table').DataTable({
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
                    url: '/admin/bulletins'
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
                            data: 'title'
                            , name: 'title'
                        }, {
                            data: 'author'
                            , name: 'author'
                        }
                        , {
                            data: 'created_at'
                            , name: 'created_at'
                        }
                        , {
                            data: 'published_at'
                            , name: 'published_at'
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

        $(document).on('click', '.delete-bulletin-btn', function() {

            swal({
                    title: "Are you sure?"
                    , text: "Once deleted, All of the posts related to that bulletin will be deleted."
                    , icon: "warning"
                    , buttons: true
                    , dangerMode: true
                , })
                .then((willDelete) => {
                    if (willDelete) {
                        if (bulletinId) {
                            Dashmix.loader('show', 'bg-primary')
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: '/admin/bulletins/' + bulletinId
                                , method: "Delete"
                                , dataType: "json"
                                , success: function(response) {
                                    if (response.success) {
                                        toastr.info(" ", "Record Deleted Successfully", {
                                            iconClass: "toast-custom"
                                        });

                                        $('#bulletins-table').DataTable().ajax.reload();
                                        swal("Bulletin and Articles has been deleted!", {
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
                        swal("Your Bulletin  is safe!");
                    }
                });
            let bulletinId = $(this).data("id")

        });

        $('#filter').click(function() {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != '' && to_date != '') {
                $('#bulletins-table').DataTable().destroy();
                load_data(from_date, to_date);
            } else {
                alert('Both Date is required');
            }
        });

        $('#refresh').click(function() {
            $('#from_date').val('');
            $('#to_date').val('');
            $('#bulletins-table').DataTable().destroy();
            load_data();
        });

        $('.dataTables_filter input[type="search"]').css({
            'width': '400px'
            , 'display': 'none'
        });
    });

</script>
@endsection
