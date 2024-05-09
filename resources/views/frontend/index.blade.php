@extends('layouts.frontend.master')
@section('title','Towards Media')
@section('content')

<div class="container">
    <div class="row align-items-end">
        <div id="carouselExampleIndicators" class="pb-2 carousel slide col-sm-12 col-lg-7 col-md-7 col-xl-7" data-bs-ride="true">
            <div class="carousel-indicators  m-auto">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner pt-2 ">
                @foreach ($newIssues as $key => $post)
                <div class="carousel-item  {{$key == 0 ? 'active' : '' }}">
                    <a href="{{route('frontend.blog.show',$post->slug)}}" style="text-decoration: none">
                        <div class="d-block">
                            <h4 class="text-dark" style="line-height: 1.47em;">
                                {{$post->title}}
                            </h4>
                            <div class="overflow-hidden d-block py-1 text-truncate text-dark mb-3 ">
                                {{$post->description}}
                            </div>
                            <div class="mb-2">
                                <span class="text-black-50">{{Carbon\Carbon::parse($post->published_at)->diffForHumans()}} created by <span class="h6 text-black">Toward</span></span>
                                <span class="text-danger">
                                    <i class="fas fa-eye ms-3 me-1" style="color: red; font-size: 20px ;"></i>{{$post->number_format_short($post->views) }}
                                </span>
                            </div>
                            <img class="d-block" src="{{$post->photo()}}" alt="" style="width: 100%;height:380px;object-fit:contain;" />
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <!-- BannerCard -->
        <div class="col-sm-12 col-lg-4 col-md-4 col-xl-4 ms-lg-auto mt-2">
            <div class="my-2 d-flex justify-content-start align-items-center">
                <div class="bg-dark text-white px-2 py-1 rounded">Podcasts</div>
            </div>
            @foreach ($podcasts as $post)
            @if ($loop->index < 4)
            <a href="{{route('frontend.blog.show',$post->slug)}}" style=" text-decoration:none;">
                <div class="card border-0 mb-3 bg-dark bg-opacity-10" style="min-width: 300px; min-height: 100px;">
                    <div class="__k-card_marker card-body overflow-hidden" style="min-width: 300px; min-height: 100px;">
                        <h6 class="card-title dt mb-3" style="font-weight:bold ; color:black;">{{$post->title}}</h6>
                        <span class="mt-5 text-black-50 card-text"><small class="text-muted"> {{\Carbon\Carbon::parse($post->created_at)->format('M d, Y')}}</small>
                        </span>
                    </div>
                    <img src="{{$post->photo()}}" class="position-absolute end-0 opacity-80 d-none d-md-block" alt="" srcset="" style="object-fit: contian; height:100%;">    
                </div>
            </a>
            @endif
            @endforeach
        </div>
    </div>

    <!-- Active Issue -->
    <section>
        <div class="mt-5 mb-4 text-center">
            <span class="text-black fw-bold" style="font-size:30px;">Most Views</span>
        </div>
        <div class="row" id="active-issue">
            @include('layouts.frontend.posts',['posts'=>$mostIssues,'cols'=>'col-lg-4 col-xl-4'])
        </div>
    </section>
    <hr>

    {{-- Articles --}}
    <section>
        <div class="h1 text-center fw-bolder mt-5 mb-4" style="font-weight: bold; ">News/Articles</div>
        <div class="row" id="demo-news">
            @include('layouts.frontend.posts',['posts'=>$newArticles,'cols'=>'col-lg-4 col-xl-4'])
        </div>
    </section>

    {{-- request articles --}}
    <section class=" mt-5 mb-3">
        <div class="card bg-dark text-white">
            <img src="{{asset('assets/frontend/image/imageoverlay.jpg')}}" class="card-img" alt="..." style="height: 400px;" />
            <div class="card-img-overlay d-flex flex-column justify-content-center text-center" style="backdrop-filter: blur(5px);">
                <h5 class="card-title mb-3 fw-bolder mx-auto lh-base" style="font-size: 40px; max-width: 600px;;">
                    <span class="myanamr">ဆီသို့စာစဉ်သို့ အပတ်စဉ်စာမူများပေးပို့နိုင်ပါသည်။</span>
                </h5>
                <button class="btn btn-danger d-block mx-auto" style="width: 300px; height: 60px; border-radius: 100px;" onclick="document.location =  'mailto:sithojournal2021@gmail.com'">
                    <span class="fw-bold" style="font-size: 20px ;">ဆီသို့ သို့ စာမူပေးပို့ရန် </span>
                    <i class="fas fa-arrow-circle-right ms-3" style="font-size:20px ;"></i>
                </button>
            </div>
        </div>
    </section>
    <!-- newsletter -->
    <section>
        <h1 class="h1 text-center fw-bolder mt-5 mb-4" style="font-weight: bold;">Newsletter</h1>
        <div class="row" id="demo-news">
            @include('layouts.frontend.posts',['posts'=>$newsletters,'cols'=>'col-lg-4 col-xl-4'])
        </div>
    </section>
    <hr>
    <!---->
    <!-- newsBulletin -->
    <section>
        <h1 class="h1 text-center fw-bolder mt-5 mb-4" style="font-weight: bold;">News Bulletin</h1>
        <div class="row" id="demo-news">
            @include('layouts.frontend.posts',['posts'=>$newsbulletins,'cols'=>'col-lg-4 col-xl-4'])
        </div>
    </section>
    <!---->
    <hr>
    {{-- podcasts --}}
    <div class="d-block overflow-hidden">
        <h1 class="h1 text-center fw-bolder mt-5 mb-4" style="font-weight: bold;">Podcasts</h1>
        <div class="row">
            @foreach ($podcasts as $podcast)
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">

                <div class="row mb-5">
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <img src="{{$podcast->photo()}}" alt="" srcset="" class="img-thumbnail" />
                    </div>
                    <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8  my-auto ">
                        <h5 class="h5 fw-bold">{{$podcast->title}}</h5>
                        <div class="overflow-hidden d-block my-3 text-truncate">ဆီ
                            {{$podcast->description}}
                        </div>
                        <div>
                            <span class="mt-5 text-black-50 card-text"><small class="text-muted"> {{\Carbon\Carbon::parse($podcast->created_at)->format('M d, Y')}} createby <span class="h6 text-black">Toward</span></small>
                            </span>
                            <span class="text-danger"><i class="fas fa-eye mx-1" style="color: red; font-size: 12px ;"></i>{{$podcast->number_format_short($podcast->views) }}</span>
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
    <div class="pt-5 pb-4">
        <a href="{{route('podcasts')}}" class="btn btn-danger d-flex justify-content-center align-items-center mx-auto" style="width: 300px; height: 60px; border-radius: 100px;">
            <span class="fw-bold" style="font-size: 20px ;">
                View All Podcast
            </span>
            <i class="fas fa-arrow-circle-right ms-3" style="font-size:20px ;"></i>
        </a>
    </div>

</div>

@endsection
