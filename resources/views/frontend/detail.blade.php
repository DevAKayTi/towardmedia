@extends('layouts.frontend.master')
@section('title',$post->title)
@section('image_url',asset('storage/uploads/featured/'.$post->post_thumbnail))

@section('content')
<?php
function number_format_short( $n, $precision = 1 ) {
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } else if ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n / 1000, $precision);
        $suffix = 'K';
    } else if ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n / 1000000, $precision);
        $suffix = 'M';
    } else if ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n / 1000000000, $precision);
        $suffix = 'B';
    } else {
        // 0.9t+
        $n_format = number_format($n / 1000000000000, $precision);
        $suffix = 'T';
    }

  // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
  // Intentionally does not affect partials, eg "1.50" -> "1.50"
    if ( $precision > 0 ) {
        $dotzero = '.' . str_repeat( '0', $precision );
        $n_format = str_replace( $dotzero, '', $n_format );
    }

    return $n_format . $suffix;
}
?>

<div class="container" style="padding-left: 100px; padding-right: 100px">
    <span class="h4" style="line-height: 45px">{{$post->title}}</span>
    <br />
    <span class="mt-4 text-black-50">{{\Carbon\Carbon::parse($post->created_at)->format('M d, Y')}} created by <span class="h6 text-black">Toward</span></span>
    <span class="text-danger"><i class="fas fa-eye ms-3 me-1" style="color: red; font-size: 20px"></i>{{number_format_short($post->views) }}</span>
    <div class=" my-3">
        @include('layouts.frontend.utils.tags',['tags'=>$post->tags])
    </div>

    <div class="text-center mb-5">
        <img class="d-block rounded " src="{{asset('storage/uploads/featured/'.$post->post_thumbnail.'')}}" alt="" style="width: 80%; height: 500px; object-fit: contain;" />
    </div>
    <div>
    @if(filter_var(strip_tags($post->content), FILTER_VALIDATE_URL))
        <div>{{$post->description}}</div>
        <a href="{{ strip_tags($post->content) }}" class="btn btn-primary mt-5">Read More</a>
    @else
        {!! $post->content !!}
    @endif
    </div>
    
</div>
@endsection
