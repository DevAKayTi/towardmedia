@extends('layouts.frontend.master')
@section('content')

<main id="main-container">
    <!-- Hero -->
    <div class="bg-image" style="background-image: url('assets/photo17@2x.jpg');">
        <div class="bg-black-50">
            <div class="content content-top content-full text-center">
                <h1 class="fw-bold text-white mt-5 mb-2">
                    Check out our latest stories
                </h1>
                <h3 class="fw-normal text-white-75 mb-5">Be inspired and create something amazing today.</h3>
            </div>
        </div>
    </div>
    <div class="content content-full">
        <div class="row items-push">
            @foreach ($posts as $post)
            <div class="col-lg-4">
                <a class="block block-rounded block-link-pop h-100 mb-0" href="{{route('frontend.blog.show',$post->slug)}}">

                    <img class="img-fluid " src="{{ url('featured/'.$post->post_thumbnail)}}" alt="">
                    <div class="block-content">
                        <h4 class="mb-1">{{$post->title}}</h4>
                        <p class="fs-sm">
                            <span class="text-primary">{{$post->author->name}}</span> on {{\Carbon\Carbon::parse($post->published_at)->format('M d, Y')}}
                        </p>
                        <p>
                            {!! \Illuminate\Support\Str::limit($post->description, 100) !!}
                        </p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <a href="{{route('frontend.blog.index')}}" class=" btn btn-primary">Show All</a>
            </div>
        </div>

    </div>
</main>
@endsection
