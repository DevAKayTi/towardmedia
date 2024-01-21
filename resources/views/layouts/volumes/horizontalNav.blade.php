<div class="bg-white p-3 rounded push">
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
                <a class="nav-main-link {{isset($overview) ? $overview : ' '}} " href="{{route('volumes.show',$volume->id)}}">
                    <i class="nav-main-link-icon fa fa-rocket"></i>
                    <span class="nav-main-link-name">Overview</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link {{isset($edit) ? $edit : ' '}} " href="{{route('volumes.edit',$volume->id)}}">
                    <i class="fas fa-edit  nav-main-link-icon  "></i>
                    <span class="nav-main-link-name">Edit</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link {{isset($articles) ? $articles : ' '}} " href="{{route('volumes.articles',$volume->id)}}">
                    <i class="nav-main-link-icon fa fa-thumbtack"></i>
                    <span class="nav-main-link-name">Articles</span>
                </a>
            </li>

        </ul>
    </div>
    <!-- END Navigation -->
</div>
