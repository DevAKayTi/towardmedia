@extends('layouts.backend.master')
@section('content')
<div class="content">

    @include('layouts.nav_tab',['authorPasswordReset'=>'active'])
    <form action="{{ route('authors.passwordReset.post',$author->id) }}" method="POST">
        @csrf

        <div class="block">
            <div class="block-header block-header-default">
                <h4 class="card-title"> Password Reset </h4>
            </div>
            <div class="block-content">
                <div class="row justify-content-center push">
                    <div class="col-md-10">
                        <div class="form-group mt-3">
                            <label> Email </label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{$author->email}}" disabled>
                            <input type="hidden" class="form-control " name="email" value="{{$author->email}}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
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
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="block-content">
                <div class="row justify-content-center push">
                    <div class="col-md-10">
                        <div class="form-group mt-3">
                            <label for="password-confirm" class="">{{ __('Confirm Password') }}</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="new-password">
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="block-content bg-body-light">
                <div class="row justify-content-center push">
                    <div class="col-md-10">
                        <button type="submit" class="btn btn-alt-primary">
                            <i class="fa fa-fw fa-check opacity-50 me-1"></i> {{ __('Reset Password') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection
