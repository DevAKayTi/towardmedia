@extends('layouts.app')
@section('content')
<div class="container mt-5">

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="row">

            <div class="col-xl-8 col-lg-8 col-sm-12 col-12 m-auto">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="card-title"> Category </h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <label> Name </label>
                            <input type="text" class="form-control mb-2" name="name" placeholder="Enter the name" value="{{ old('name') }}">
                            @error('name')
                            <span class="text-danger  ">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"> Save </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
