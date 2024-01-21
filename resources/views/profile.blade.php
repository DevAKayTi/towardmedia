@extends('layouts.backend.master')
@section('content')

<div class="bg-image" style="background-image: url('/assets/photo17@2x.jpg');">
    <div class="bg-black-75">
        <div class="content content-full">
            <div class="py-5 text-center">
                <a class="img-link" href="be_pages_generic_profile.html">
                    <img class="img-avatar img-avatar96 img-avatar-thumb" src="https://ui-avatars.com/api/?name={{auth()->user()->name}}?background=0D8ABC&color=000000" alt="">
                </a>
                <h1 class="fw-bold my-2 text-white">Edit Account</h1>
                <h2 class="h4 fw-bold text-white-75 text-capitalize">
                    {{auth()->user()->name}}
                </h2>
                <a class="btn btn-secondary" href="{{route('dashboard')}}">
                    <i class="fa fa-fw fa-arrow-left opacity-50"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
<div class="content content-full content-boxed">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{route('updateProfile',auth()->user()->id)}}" method="POST" id="profile-update-form">
                @csrf
                <!-- User Profile -->
                <h2 class="content-heading pt-0">
                    <i class="fa fa-fw fa-user-circle text-muted me-1"></i> User Profile
                </h2>
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Your account’s vital info. Your username will be publicly visible.
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="mb-4">
                            <label class="form-label" for="name">Username</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter your username.." value="{{auth()->user()->name}}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email.." value="{{auth()->user()->email}}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" placeholder="Add your job title.." value="{{auth()->user()->role == 2 ? 'Admin' : 'Author'}}" readonly>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Company</label>
                            <input type="text" class="form-control text-capitalize" value="{{'towards'}}" readonly>
                        </div>

                    </div>
                </div>

                <!-- Submit -->
                <div class="row push">
                    <div class="col-lg-8 col-xl-5 offset-lg-4">
                        <div class="mb-4">
                            <button type="submit" class="btn btn-alt-primary">
                                <i class="fa fa-check-circle opacity-50 me-1"></i> Update Profile
                            </button>
                        </div>
                    </div>
                </div>
                <!-- END Submit -->
            </form>
        </div>
    </div>
</div>
@endsection
