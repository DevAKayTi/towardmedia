@extends('layouts.backend.master')
@section('css')

@endsection
@section('content')
<div class="container">


    <div class="content">
        <!-- Dynamic Table Full -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <a class="btn btn-primary" href="{{route('authors.create')}}"> Create New User</a>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped " id="authors-data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Staus</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>


</div>
@endsection

@section('footer-scripts')

<script type="text/javascript">
    $(document).ready(function() {
        let table = $('#authors-data-table').DataTable({
            "processing": true
            , "serverSide": true
            , ajax: "/admin/authors"
            , columns: [{
                    data: 'DT_RowIndex'
                    , name: 'DT_RowIndex'
                    , orderable: false
                    , searchable: false
                }
                , {
                    data: 'name'
                    , name: 'name'
                }, {
                    data: 'email'
                    , name: 'email'
                }, {
                    data: 'role'
                    , name: 'role'
                }, {
                    data: 'status'
                    , name: 'status'
                }, {
                    data: 'action'
                    , name: 'action'
                    , orderable: false
                    , searchable: false
                }
            , ]

        });
        $(document).on('click', '.user-status-toggle-button', function() {
            let authorId = $(this).data("id")
            Dashmix.loader('show', 'bg-primary')
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST"
                , url: "/admin/authors/changeStatus"
                , data: {
                    id: authorId
                }
                , dataType: "json"
                , success: function(response) {
                    if (response.success) {
                        Dashmix.loader('hide')
                        toastr.success(" ", "Change User Status", {});
                    } else {
                        Dashmix.loader('hide')
                        toastr.error(response.error, 'ERROR!').css("width", "500px")
                    }
                }
            });

        });


    });

</script>
@endsection
