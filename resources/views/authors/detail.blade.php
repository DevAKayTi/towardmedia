@extends('layouts.backend.master')
@section('content')
<div class="content">
    @if(Session::has('success'))
    <div class="alert alert-success w-25">
        {{ Session::get('success') }}
    </div>
    @endif
    @include('layouts.nav_tab',['detailActive'=>'active'])

    <div class="block">
        <div class="block-header block-header-default">
            <a class="btn btn-alt-secondary" href="{{route('authors.index')}}">
                <i class="fa fa-arrow-left me-1"></i> Manage Users
            </a>
        </div>
        <div class="block-content">
            <div class="row justify-content-center push">
                <div class="col-md-10">
                    <label> Name</label>
                    <input type="text" class="form-control" value="{{$author->name}}" disabled>
                </div>

            </div>
        </div>
        <div class="block-content">
            <div class="row justify-content-center push">
                <div class="col-md-10">
                    <label> Email</label>
                    <input type="text" class="form-control" value="{{$author->email}}" disabled>
                </div>
            </div>
        </div>
        <div class="block-content">
            <div class="row justify-content-center push">
                <div class="col-md-10">
                    <label> Status</label>
                    <input type="text" class="form-control" value="{{App\Enums\UserStatusType::Active==$author->status ? 'Active' : 'Inactive'}}" disabled>
                </div>
            </div>
        </div>
        <div class="block-content">
            <div class="row justify-content-center push">
                <div class="col-md-10">
                    <label> Role </label>
                    @if ($author->role ===1)
                    <input type="text" class="form-control" value="author" disabled>
                    @else
                    <input type="text" class="form-control text-capitalize " value="admin" disabled>
                    @endif
                </div>
            </div>
        </div>
        <div class="block-content">
            <div class="row justify-content-center push">
                <div class="col-md-10">
                    <label> Ip </label>
                    @if ($author->ip === null)
                    <input type="text" class="form-control" value="" disabled>
                    @else
                    <input type="text" class="form-control" value="{{$author->ip}}" disabled>
                    @endif
                </div>
            </div>
        </div>
        <div class="block-content">
            <div class="row justify-content-center push">
                <div class="col-md-10">
                    <label> Logined At </label>
                    @if ($author->logined_at === null)
                    <input type="text" class="form-control" value="" disabled>
                    @else
                    <input type="text" class="form-control" value="{{\Carbon\Carbon::parse($author->logined_at)->format('d-M-Y (g:i A)')}} {{\Carbon\Carbon::parse($author->logined_at)->diffForHumans()}}" disabled>
                    @endif
                </div>
            </div>
        </div>
        <div class="block-content">
            <div class="row justify-content-center push">
                <div class="col-md-10">
                    <label> Posts (Count) </label>
                    <input type="text" class="form-control" value="{{$author->posts()->get()->count()}}" disabled>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
