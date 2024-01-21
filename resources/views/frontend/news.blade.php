@extends('layouts.frontend.master')
@section('title','Towards Media')

@section('content')


<div class="container">
    <div class="container mt-5">
        <div class="container mt-5">
            <div class="row" id="popular">
                @include('layouts.frontend.posts',['posts'=>$news,'cols'=>'col-lg-4 col-xl-4'])
            </div>
        </div>
    </div>
    <div class="text-center">
        <ul class=" pagination justify-content-center">
            {{$news->links()}}
        </ul>
    </div>
</div>
@endsection
