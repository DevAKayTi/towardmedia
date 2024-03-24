@extends('layouts.frontend.master')
@section('title','Towards Media')

@section('content')

<div class="container pt-3 pb-5" style="margin-top:120px">
    <form action="{{route('subscribe.create')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1 class="fw-bold mb-3">Subscribe To Towards Media</h1>
        <h5 class=" opacity-75">Get updates all newsletter and new bulletins.</h5>    

        <div class="input-group mt-5" style="width:400px">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your e-mail" aria-label="Recipient's username" aria-describedby="button-addon2">
            <button class="btn btn-danger" type="submit" id="button-addon2">Subscribe</button>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            @if(session('success'))
            <div class="mt-3 opacity-50">
                <p class="text-success">{{ session('success') }}</p>
            </div>
            @endif
        </div>
    </form>
</div>

@endsection