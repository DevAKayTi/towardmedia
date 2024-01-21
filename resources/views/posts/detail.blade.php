@extends('layouts.backend.master')
@section('content')
<div class="bg-image" style="background-image: url('/storage/uploads/featured/{{$post->post_thumbnail}}');">
    <div class="bg-black-75">
        <div class="content content-top content-full text-center">
            <h1 class="fw-bold text-white mt-5 mb-3">
                {{$post->title}}
            </h1>
            <h2 class="h3 fw-normal text-white-75 mb-5">{{$post->description}}</h2>
            <p>
                <span class="badge rounded-pill bg-primary fs-base px-3 py-2 me-2 m-1">
                    <i class="fa fa-user-circle me-1"></i> by {{$post->author->name}}
                </span>
                @if (auth()->user()->can('update', $post))
                <a class="badge rounded-pill bg-warning fs-base px-3 py-2 m-1 my-button" href="{{route('blogs.edit',$post->id)}}">
                    <i class="far fa-fw fa-edit me-1"></i>Edit
                </a>
                <form action="{{route('blogs.destroy',$post->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class=" btn btn-danger ms-3 badge rounded-pill bg-danger fs-base px-3 py-2 m-1" onclick="return confirm('Are you sure you want to delete this item?');">
                        <i class="fa fa-trash me-1"></i> Delete
                    </button>
                </form>
                @endif

            </p>
        </div>
    </div>
</div>
<div class="content content-full">
    <div class="row justify-content-center">
        <div class="col-sm-8 py-5">

            <div class="js-gallery story">
                {!! $post->content !!}
            </div>
            <div class="  p-4   ">
                <i class="fa fa-fw fa-tags me-1"></i>
                @foreach ($post->tags as $tag)
                <span class="badge bg-primary fst-italic fs-5 ">{{$tag->name}}</span>
                @endforeach
                {{-- <span class="badge bg-primary">Sass</span>
                <span class="badge bg-primary">Less</span> --}}
            </div>
        </div>
    </div>
</div>
<!-- END Hero -->
@endsection

@section('footer-scripts')
<script>
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
                            $('#postCount').text(count);
                            $('#postCountDatatable').text(count)
                            table.ajax.reload();
                        } else {
                            if (response.error) {
                                toastr.error(" ", response.error, {}).css("width", "500px")
                            }
                        }
                    }
                });
            }
        }
    });

</script>
@endsection
