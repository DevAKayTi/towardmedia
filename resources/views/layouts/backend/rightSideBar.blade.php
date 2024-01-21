<aside id="side-overlay">
    <!-- Side Header -->
    <div class="bg-image">
        <div class="bg-primary-op">
            <div class="content-header">
                <!-- User Avatar -->
                <a class="img-link me-1" href="#">
                    <img class="img-avatar img-avatar48" src="https://ui-avatars.com/api/?name={{auth()->user()->name}}?background=0D8ABC&color=000000" alt="">
                </a>
                <!-- END User Avatar -->

                <!-- User Info -->
                <div class="ms-2">
                    <a class="text-white fw-semibold text-capitalize" href="#">{{auth()->user()->name}}</a>
                    <div class="text-white-75 fs-sm text-capitalize">{{auth()->user()->role==2 ? 'admin' :'author'}}</div>
                </div>
                <!-- END User Info -->

                <!-- Close Side Overlay -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <a class="ms-auto text-white" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_close">
                    <i class="fa fa-times-circle"></i>
                </a>
                <!-- END Close Side Overlay -->
            </div>
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Side Content -->
    <div class="content-side">
        <!-- Side Overlay Tabs -->
        <div class="block block-transparent pull-x pull-t mb-0">
            <div class="block-content tab-content overflow-hidden">

                <!-- Profile -->
                <div class="tab-pane pull-x fade fade-up show active" id="so-profile" role="tabpanel" aria-labelledby="so-profile-tab">
                    <form action="{{route('auth.user.passwordChange')}}" method="POST" id="my-form">
                        @csrf
                        <div class="block mb-0">
                            <!-- Personal -->
                            <div class="block-content block-content-sm block-content-full bg-body">
                                <span class="text-uppercase fs-sm fw-bold">Personal</span>
                            </div>
                            <div class="block-content block-content-full">
                                <div class="mb-4">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" value="{{auth()->user()->name}}" disabled>
                                    <input type="hidden" class="form-control" id="name" name="name" value="{{auth()->user()->name}}">

                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control" value="{{auth()->user()->email}}" disabled>
                                    <input type="hidden" class="form-control" id="email" name="email" value="{{auth()->user()->email}}">

                                </div>
                            </div>
                            <!-- END Personal -->

                            <!-- Password Update -->
                            <div class="block-content block-content-sm block-content-full bg-body">
                                <span class="text-uppercase fs-sm fw-bold">Password Update</span>
                            </div>
                            <div class="block-content block-content-full">
                                <div class="mb-4">
                                    <label class="form-label" for="current_password">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="password">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="password_confirmation">Confirm New Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                            <!-- END Password Update -->

                            <!-- Submit -->
                            <div class="block-content block-content-full border-top">
                                <button type="submit" class="btn w-100 btn-alt-primary">
                                    <i class="fa fa-fw fa-save me-1 opacity-50"></i> Save
                                </button>
                            </div>
                            <!-- END Submit -->
                        </div>
                    </form>
                </div>
                <!-- END Profile -->
            </div>
        </div>
        <!-- END Side Overlay Tabs -->
    </div>
    <!-- END Side Content -->
</aside>
