@foreach ($tags as $tag)
<a href="{{route('frontend.blog.groupByTag',$tag->name)}}" class="btn btn-dark btn-sm me-1 text-capitalize px-3 " style=" border-radius:17px;">{{$tag->name}}
</a>
@endforeach
