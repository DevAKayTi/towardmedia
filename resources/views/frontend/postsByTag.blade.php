@extends('layouts.frontend.master')
@section('title','Towards Media')

@section('content')
    <?php
    function number_format_short($n, $precision = 1)
    {
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
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }

        return $n_format . $suffix;
    }
    ?>
    <div class="container-fullwidth">

        <div class="btn-menu col-md-12 text-center">
            <button type="button" class="btn btn-danger btn-sm rounded pt-0 text-capitalize"
                    style="height:25px;">{{$selectedTag->name}}</button>
        </div>
        <hr/>
        <div class="container mt-5">
            <div class="container mt-5">
                <div class="row" id="popular">
                    @include('layouts.frontend.posts',['posts'=>$posts,'cols'=>'col-lg-4 col-xl-4'])
                </div>
            </div>
        </div>
        <div class="text-center">
            <ul class=" pagination justify-content-center">
                {{$posts->links()}}
            </ul>
        </div>
    </div>

@endsection
