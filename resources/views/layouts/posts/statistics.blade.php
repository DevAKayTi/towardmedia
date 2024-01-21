 <!-- Posts Statistics -->
 <div class="row text-center">
     <div class="col-6 col-xl-3">
         <!-- All Posts -->
         <a class="block block-rounded   {{ (request()->is('admin/blogs') ? 'shadow-lg' : 'shadow-none')}} " href="{{route('blogs.index')}}">
             <div class="block-content block-content-full">
                 <div class="py-md-3">
                     <div class="py-3 d-none d-md-block">
                         <i class="far fa-2x fa-file-alt text-primary "></i>
                     </div>
                     <p class="fs-4 fw-bold mb-0" data-id="{{$allPosts}}" id="postCount">
                         {{$allPosts}}
                     </p>
                     <p class="text-muted mb-0">
                         All Posts
                     </p>
                 </div>
             </div>
         </a>
         <!-- END All Posts -->
     </div>

     <div class="col-6 col-xl-3">
         <!-- Published  Posts -->
         <a class="block block-rounded {{ (request()->is('admin/blogs/published') ? 'shadow-lg' : 'shadow-none')}}" href="{{route('blogs.published')}}">
             <div class="block-content block-content-full">
                 <div class="py-md-3">
                     <div class="py-3 d-none d-md-block">
                         <i class="far fa-2x fa-file-alt text-primary"></i>
                     </div>
                     <p class="fs-4 fw-bold mb-0" data-id="{{$publishedPosts}}" id="publishedPostsCount">
                         {{$publishedPosts}}
                     </p>
                     <p class="text-muted mb-0">
                         Published Posts
                     </p>
                 </div>
             </div>
         </a>
         <!-- END Published  Posts -->
     </div>
     <div class="col-6 col-xl-3">
         <!-- Published  Posts -->
         <a class="block block-rounded {{ (request()->is('admin/blogs/unpublished') ? 'shadow-lg' : 'shadow-none')}}" href="{{route('blogs.unpublished')}}">
             <div class="block-content block-content-full">
                 <div class="py-md-3">
                     <div class="py-3 d-none d-md-block">
                         <i class="far fa-2x fa-file-alt text-primary"></i>
                     </div>
                     <p class="fs-4 fw-bold mb-0" data-id="{{$unpublishedPosts}}" id="unpublishedPostsCount">
                         {{$unpublishedPosts}}
                     </p>
                     <p class=" mb-0  text-muted">
                         Unpublished Posts
                     </p>
                 </div>
             </div>
         </a>
         <!-- END Published  Posts -->
     </div>
     <div class="col-6 col-xl-3">
         <a class="block block-rounded" href="{{route('blogs.create')}}">
             <div class="block-content block-content-full">
                 <div class="py-md-3">
                     <div class="py-3 d-none d-md-block">
                         <i class="fa fa-2x fa-plus text-primary"></i>
                     </div>
                     <p class="fs-4 fw-bold mb-0">
                         <i class="fa fa-plus text-primary me-1 d-md-none"></i> New Post
                     </p>
                     <p class="text-muted mb-0">
                         by {{auth()->user()->name}}
                     </p>
                 </div>
             </div>
         </a>
     </div>
 </div>

 {{-- filter  --}}

 <!-- Post Statistics -->
