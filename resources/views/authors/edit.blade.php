@extends('layouts.backend.master')
@section('content')
<div class="content">
    @include('layouts.nav_tab',['authorEditActive'=>'active'])
    <form action="{{ route('authors.update',$author->id) }}" method="POST">
        @csrf
        {{ method_field('PATCH') }}

        <div class="block ">

            <div class="block-header block-header-default">
                <h4 class="card-title"> Author Update </h4>
            </div>
            <div class="block-content">
                <div class="row justify-content-center push">
                    <div class="col-md-10">
                        <div class="form-group mt-3">
                            <label> Name </label>
                            <input type="text" name="name" class="form-control" value="{{$author->name}}">
                            @error('name')
                            <span class="text-danger mt-0 ">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>
            <div class="block-content">
                <div class="row justify-content-center push">
                    <div class="col-md-10">
                        <div class="form-group mt-3">
                            <label> Email </label>
                            <input type="text" class="form-control" name="email" value="{{$author->email}}">
                            @error('email')
                            <span class="text-danger mt-0 ">{{$message}}</span>
                            @enderror
                        </div>

                    </div>
                </div>

            </div>
            <div class="block-content">
                <div class="row justify-content-center push">
                    <div class="col-md-10">
                        <div class="form-group mt-3">
                            <label> Role </label>
                            <select class="form-control" name="role">
                                <option value="1" @if ($author->role===1) selected @endif >Author</option>
                                <option value="2" @if ($author->role===2) selected @endif >Admin</option>
                            </select>
                        </div>

                    </div>
                </div>

            </div>
            <div class="block-content bg-body-light">
                <div class="row justify-content-center push">
                    <div class="col-md-10">
                        <button type="submit" class="btn btn-alt-primary">
                            <i class="fa fa-fw fa-check opacity-50 me-1"></i> Upate Information
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
