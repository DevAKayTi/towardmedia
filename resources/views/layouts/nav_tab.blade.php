<div class=" mt-2 bg-white p-3 rounded push">
    <!-- Toggle Navigation -->
    <div class="d-lg-none">
        <!-- Class Toggle, functionality initialized in Helpers.dmToggleClass() -->
        <button type="button" class="btn w-100 btn-light d-flex justify-content-between align-items-center" data-toggle="class-toggle" data-target="#horizontal-navigation-hover-normal" data-class="d-none">
            Menu - Hover Normal
            <i class="fa fa-bars"></i>
        </button>
    </div>
    <!-- END Toggle Navigation -->

    <!-- Navigation -->
    <div id="horizontal-navigation-hover-normal" class="d-none d-lg-block mt-2 mt-lg-0">
        <ul class="nav-main nav-main-horizontal nav-main-hover">
            <li class="nav-main-item">
                <a class="nav-main-link {{isset($detailActive) ? $detailActive : ' '}} " href="{{route('authors.show',$author->id)}}">
                    <i class="far fa-fw fa-user nav-main-link-icon me-1"></i>{{$author->name}} Detail </a>
            </li>
            @can('update',$author)
            <li class="nav-main-item">
                <a class="nav-main-link text-capitalize {{isset($authorEditActive) ? $authorEditActive : ' '}} " href="{{route('authors.edit',$author->id)}}">
                    <i class="fas fa-edit  nav-main-link-icon  "></i>
                    Edit {{$author->name}}'s Information</a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link text-capitalize {{isset($authorPasswordReset) ? $authorPasswordReset : ' '}} " href="{{route('authors.passwordReset',$author->id)}}">
                    <i class="fa fa-fw fa-wrench me-1 nav-main-link-icon"></i>
                    Password Reset
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link text-capitalize {{isset($postsActive) ? $postsActive : ' '}} " href="{{route('authors.posts',$author->id)}}">
                    <i class="nav-main-link-icon fa fa-thumbtack"></i>
                    {{$author->name}}'s posts
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link text-capitalize {{isset($activitiesActive) ? $activitiesActive : ' '}} " href="{{route('authors.activities',$author->id)}}">
                    <i class="far fa-fw fa-building me-1 nav-main-link-icon"></i>{{$author->name}}'s activities</a>
            </li>
            @endcan
        </ul>
    </div>
    <!-- END Navigation -->
</div>
