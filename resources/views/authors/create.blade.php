@extends('layouts.backend.master')
@section('content')
<div class="container">
    <form action="{{ route('authors.store') }}" method="POST">
        @csrf
        <div class="block mt-3">

            <div class="block-header block-header-default">
                <h4 class="card-title"> Create New User </h4>
            </div>
            <div class="block-content">
                <div class="row justify-content-center push">
                    <div class="col-md-10">
                        <div class="form-group mt-3">
                            <label> Name </label>
                            <input type="text" name="name" class="form-control" value="{{old('name')}}">
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
                            <input type="text" class="form-control" name="email" value="{{old('email')}}">
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
                            <label> Password </label>
                            <input type="text" class="form-control" name="password" value="{{old('password')}}">
                            @error('password')
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
                                <option value="1">Author</option>
                                <option value="2">Admin</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="block-content bg-body-light">
                <div class="row justify-content-center push">
                    <div class="col-md-10">
                        <button type="submit" class="btn btn-alt-primary">
                            <i class="fa fa-fw fa-check opacity-50 me-1"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection
