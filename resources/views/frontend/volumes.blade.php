@extends('layouts.frontend.master')
@section('title','Towards Media')

@section('content')

    <div class="container">
        <div class="container mt-5">
            <div class="container mt-5">
                <div class="row" id="popular">
                    @foreach ($volumes as $volume)

                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 px-5 mb-5 ">
                            <img src="{{$volume->photo()}}" class="mt-3 " alt=""
                                 style="width:100%; border-radius:20px; height: 280px;object-fit: contain; ">
                            <span class="h5 d-block mt-3 fw-bold fs-6">{{$volume->title}}</span>

                            <div class=" text-black-50 card-text my-3 ">
                                <small
                                    class="text-muted"> {{\Carbon\Carbon::parse($volume->created_at)->format('M d, Y')}}
                                    created by
                                    <span class="h6 text-black">
                                Toward
                            </span>
                                </small>
                            </div>
                            <a href="{{route('frontend.volumes.show',['id'=>$volume->id])}}"
                               class="btn btn-danger btn-lg btn-block col-12">READ NOW</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="text-center">
            <ul class=" pagination justify-content-center">
                {{$volumes->links()}}
            </ul>
        </div>
    </div>

@endsection
