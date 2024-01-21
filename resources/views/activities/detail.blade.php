@extends('layouts.backend.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-8 col-lg-8 col-sm-12 col-12 m-auto">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="card-title"> Actitvity Log </h4>
                </div>
                <div class="card-body">
                    <div class="form-group mt-3">
                        <label> Log Name</label>
                        <input type="text" class="form-control mb-2 text-capitalize" value="{{$activity->log_name}}" disabled>
                    </div>
                    <div class="form-group mt-3">
                        <label> Event</label>
                        <input type="text" class="form-control mb-2 text-capitalize" value="{{$activity->event}}" disabled>
                    </div>
                    <div class="form-group mt-3">
                        <label> Description </label>
                        <input type="text" class="form-control mb-2 " value="{{$activity->description   }} " disabled>
                        @if (($activity->log_name === 'post' && $activity->event !== 'deleted' ))
                        @if($activity->subject)
                        <a href={{route('blogs.show',$activity->subject->id)}}> Show {{$activity->event}} {{$activity->log_name }}</a>
                        @else
                        <span class=" text-danger">***This post has been already deleted.</span>
                        @endif
                        @endif
                    </div>
                    @if ($activity->event === 'login success')
                    <label> Ip </label>
                    <input type="text" class="form-control mb-2 " value="{{$ip}}" disabled>

                    @endif
                    <div class="form-group mt-3">
                        <label> Date </label>
                        <input type="text" class="form-control mb-2 " value="{{\Carbon\Carbon::parse($activity->created_at)->diffForHumans()}}" disabled>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
