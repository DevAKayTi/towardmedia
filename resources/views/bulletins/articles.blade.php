@extends('layouts.backend.master')
@section('content')
<div class="content">

    <main>
        <!-- Dynamic Table Full -->
        <input type="hidden" name="bulletinId" id="bulletinId" value="{{$bulletin->id}}">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title ">Posts (<span id="postCountDatatable">{{$articles->count()}}</span>)</h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-striped table-borderless table-vcenter " id="articles-table">
                    <thead>

                        <tr class="bg-body-dark">
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Type</th>
                            <th>View</th>
                            <th>Published</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </main>
</div>
@endsection
@section('footer-scripts')
<script>
    $(document).ready(function() {
        let bulletinId = $('#bulletinId').val()

        $('#articles-table').DataTable({
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
            , ajax: {
                url: `/admin/bulletins/${bulletinId}/articles`
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
                        data: 'type_id'
                        , name: 'type_id'
                    }
                    , {
                        data: 'views'
                        , name: 'views'
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
        $(document).on('click', '.delete-post-btn', function() {
            let postId = $(this).data('id');
            if (confirm('Are you sure you want to delete this item?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "DELETE"
                    , url: `/admin/blogs/${postId}`
                    , complete: function({
                        responseJSON
                    }) {
                        console.log(responseJSON);
                        if (responseJSON.success) {
                            let result = +$('#postCountDatatable').text() - 1
                            $('#postCountDatatable').text(result)
                        }
                    }
                    , success: function(response) {
                        if (response.success) {
                            toastr.info(" ", "Record Deleted Successfully", {
                                iconClass: "toast-custom"
                            });
                            $('#articles-table').DataTable().ajax.reload();
                        } else {
                            if (response.error) {
                                toastr.error(response.error, 'ERROR!').css("width", "500px")
                            }
                        }
                    }
                });
            }
        });
    });

</script>
@endsection
