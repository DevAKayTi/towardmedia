@extends('layouts.frontend.master')
@section('title','Towards Media')

@section('content')

<div class="container">
    <div class="d-block overflow-hidden">
        <h1 class="h1 text-center fw-bolder  mb-4" style="font-weight: bold;">Podcasts</h1>
        <div class="row">
            @foreach ($podcasts as $podcast)
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">

                <div class="row mb-5">
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <img src="{{$podcast->photo()}}" alt="" srcset="" class="img-thumbnail" />
                    </div>
                    <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8  my-auto ">
                        <h5 class="h5 fw-bold">{{$podcast->title}}</h5>
                        <div class="overflow-hidden d-block my-3 text-truncate">
                            {{$podcast->description}}
                        </div>
                        <div>
                            <span class="mt-5 text-black-50 card-text"><small class="text-muted"> {{\Carbon\Carbon::parse($podcast->created_at)->format('M d, Y')}} createby <span class="h6 text-black">Toward</span></small>
                            </span>
                            <span class="text-danger">
                                <i class="fas fa-eye mx-1" style="color: red; font-size: 12px ;"></i>{{$podcast->number_format_short($podcast->views) }}
                            </span>
                        </div>
                        <div class="  mt-3">
                            <a class="btn btn-danger px-4 " href="{{route('frontend.blog.show',$podcast->slug)}}">Play</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="text-center">
        <ul class=" pagination justify-content-center">
            {{$podcasts->links()}}
        </ul>
    </div>
</div>
@endsection
