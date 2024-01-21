@extends('layouts.frontend.master')
@section('title','Towards Media')

@section('content')


<div class="container">
    <div class="container mt-5">
        <div class="container mt-5">
            <div class="row" id="popular">
                @include('layouts.frontend.posts',['posts'=>$articles,'cols'=>'col-lg-4 col-xl-4'])
            </div>
        </div>
    </div>
    <div class="text-center">
        <ul class=" pagination justify-content-center text-danger">
            {{$articles->onEachSide(1)->links()}}
        </ul>
    </div>
</div>
@endsection
