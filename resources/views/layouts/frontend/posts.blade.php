@foreach ($posts as $post)

<div class="col-sm-12 col-md-6 {{$cols}} px-3 mb-4">
    <a href="{{route('frontend.blog.show',$post->slug)}}" style="text-decoration:none;">

        <img src="{{$post->photo()}}" class="d-block" alt="" srcset="" style="width:100%;object-fit: cover; height:300px; border-radius:10px;">
        <h5 class="h5 mt-3 mb-2 fw-bold fs-6 text-black">{{$post->title}}</h5>
        <div class="overflow-hidden mb-3 text-black text-truncate">
            {{$post->description}}
        </div>
        <div class="d-flex align-items-center  pb-3">
            <div class=" d-flex justify-content-center align-items-center ">
                @include('layouts.frontend.utils.tags',['tags'=>$post->tags()->limit(2)->get()])
            </div>
            {{-- <a href="#" class="text-danger align-middle ms-3"> View All</a> --}}
        </div>
        <div>
            <span class="mt-5 text-black-50 card-text"><small class="text-muted"> {{\Carbon\Carbon::parse($post->created_at)->format('M d, Y')}} created by <span class="h6 text-black">Toward</span></small>
            </span>
            <span class="text-danger"><i class="fas fa-eye ms-3 me-1" style="color: red; font-size: 12px ;"></i>{{$post->number_format_short($post->views) }}</span>
        </div>
    </a>
</div>
@endforeach
