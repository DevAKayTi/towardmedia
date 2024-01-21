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
        @include('layouts.posts.statistics')
        <br />
        <div class="row input-daterange">
            <div class="col-md-4">
                <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date(Published)" readonly />
            </div>
            <div class="col-md-4">
                <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date (Published)" readonly />
            </div>
            <div class="col-md-4">
                <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
            </div>
        </div>
        <br />


        <!-- Dynamic Table Full -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title ">Posts (<span id="postCountDatatable">{{$allPosts}}</span>)</h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-striped table-borderless table-vcenter " id="posts-table">
                    <thead>

                        <tr class="bg-body-dark">
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Type</th>
                            <th>Views</th>
                            <th>Published </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Type</th>
                            <th>Views</th>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#posts-table tfoot th').each(function() {
            var title = $(this).text();
            if (title == 'No' || title == 'Action' || title == 'Created' || title == 'Published') {
                $(this).html('<input type="text" class=" form-control d-none" placeholder="Search ' + title + '" />');
            } else {
                $(this).html('<input type="text" class=" form-control" placeholder="Search ' + title + '" />');

            }
        });

        load_data();

        function load_data(from_date = '', to_date = '') {
            $('#posts-table').DataTable({
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
                    url: '/admin/blogs'
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
                        }, {
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
        }

        $('#filter').click(function() {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != '' && to_date != '') {
                $('#posts-table').DataTable().destroy();
                load_data(from_date, to_date);
            } else {
                alert('Both Date is required');
            }
        });

        $('#refresh').click(function() {
            $('#from_date').val('');
            $('#to_date').val('');
            $('#posts-table').DataTable().destroy();
            load_data();
        });

        $('.dataTables_filter input[type="search"]').css({
            'width': '400px'
            , 'display': 'none'
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
                                count = +$('#postCount').data('id') - 1

                                if (response.post.published_at != null) {
                                    let totalPublishedPosts = +$('#publishedPostsCount').text() - 1;
                                    $('#publishedPostsCount').text(totalPublishedPosts);

                                } else {
                                    let totalUnpublishedPosts = +$('#unpublishedPostsCount').text() - 1;
                                    $('#unpublishedPostsCount').text(totalUnpublishedPosts);
                                }
                                $('#posts-table').DataTable().ajax.reload();
                            } else {
                                if (response.error) {
                                    toastr.error(response.error, 'ERROR!').css("width", "500px")
                                }
                            }
                        }
                    });
                }
            }
        });

        $('.dataTables_filter input[type="search"]').css({
            'width': '400px'
            , 'display': 'none'
        });
    });

</script>
@endsection
