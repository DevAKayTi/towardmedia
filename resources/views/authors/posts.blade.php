@extends('layouts.backend.master')

@section('content')
<div class="content">
    @if(Session::has('success'))
    <div class="alert alert-success w-25">
        {{ Session::get('success') }}
    </div>
    @endif
    @include('layouts.nav_tab',['postsActive'=>'active'])
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title ">Posts (<span id="postCountDatatable"></span>)</h3>
        </div>
        <div class="block-content block-content-full">
            <input type="hidden" data-id="{{$author->id}}" id="authorId" />
            <table class="table table-bordered table-hover " id="authors-posts-data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Views</th>
                        <th>Published At</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>
@endsection

@section('footer-scripts')
<script type="text/javascript">
    $(document).ready(function() {
        let authorId = $('#authorId').data('id');
        let table = $('#authors-posts-data-table').DataTable({
            "processing": true
            , "serverSide": true
            , pagingType: "full_numbers"
            , lengthMenu: [
                [7, 10, 20]
                , [7, 10, 20]
            ]
            , ajax: {
                url: `/admin/authors/${authorId}/posts`
                , complete: function({
                    responseJSON
                }) {
                    $('#postCountDatatable').text(responseJSON.recordsTotal);
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
                    , name: 'author.name'
                }
                , {
                    data: 'views'
                    , name: 'views'
                }, {
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
        });
        $(document).on('click', '.delete-post-btn', function() {
            if (confirm('Are you sure you want to delete this item?')) {
                let postId = $(this).data("id")
                if (postId) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/admin/blogs/' + postId
                        , method: "Delete"
                        , dataType: "json"
                        , success: function(response) {
                            if (response.success) {
                                toastr.info(" ", "Record Deleted Successfully", {
                                    iconClass: "toast-custom"
                                });
                                table.ajax.reload();
                            } else {
                                if (response.error) {
                                    toastr.error(" ", response.error, {});
                                }
                            }
                        }
                    });
                }
            }
        });

    });

</script>
@endsection
