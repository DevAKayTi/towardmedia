@extends('layouts.backend.master')
@section('content')
<div class="content">
    @include('layouts.volumes.horizontalNav',['overview'=>'active'])
    <div class="block">
        <div class="block-header block-header-default">
            <a class="btn btn-alt-secondary" href="{{route('volumes.index')}}">
                <i class="fa fa-arrow-left me-1"></i> Manage Volumes
            </a>
        </div>
        <div class="block-content">
            <div class="row justify-content-center push">
                <div class="col-md-10">
                    <label> Title</label>
                    <input type="text" class="form-control mb-2 text-capitalize" value="{{$volume->title}}" disabled>

                </div>
            </div>
        </div>
        <div class="block-content">
            <div class="row justify-content-center push">
                <div class="col-md-10">
                    <label> Author</label>
                    <input type="text" class="form-control mb-2 text-capitalize" value="{{$volume->author->name}}" disabled>
                </div>
            </div>
        </div>
        <div class="block-content">
            <div class="row justify-content-center push">
                <div class="col-md-10">
                    <label> Created Date </label>
                    <input type="text" class="form-control mb-2 " value="{{\Carbon\Carbon::parse($volume->created_at)->format('d-M-Y (g:i A)')}}" disabled>
                </div>
            </div>
        </div>
        <div class="block-content">
            <div class="row justify-content-center push">
                <div class="col-md-10">
                    <label> Visibility </label>
                    <select class="form-control" disabled>
                        <option value="{{0}}" {{$volume->published == 0 ? 'selected' : ''}}>Unpublished</option>
                        <option value="{{1}}" {{$volume->published == 1 ? 'selected' : ''}}>Published</option>
                    </select>
                </div>
            </div>
        </div>

        @if ($volume->published ==1)
        <div class="block-content">
            <div class="row justify-content-center push">
                <div class="col-md-10">
                    <div class="form-group mt-3">
                        <label> Published Date</label>
                        <input type="text" class="form-control mb-2 text-capitalize" value="{{\Carbon\Carbon::parse($volume->published_at ?? null)->format('d-M-Y (g:i A)')}}" disabled>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

</div>
@endsection
