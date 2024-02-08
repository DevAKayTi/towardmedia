@extends('layouts.backend.master')
@section('css')
<style>
</style>
@endsection
@section('content') <div class="content">

    <form action="{{ route('bulletins.update',$bulletin->id) }}" method="POST" id="bulletin-update-form">
        @csrf
        {{ method_field('PATCH') }}
        <div class="block">
            <div class="block-header block-header-default">
                <a class="btn btn-alt-secondary" href="{{route('bulletins.index')}}">
                    <i class="fa fa-arrow-left me-1"></i> Manage Bulletins
                </a>
            </div>

            <div class="block-content">
                @if ($bulletin->author_id !== auth()->user()->id && auth()->user()->role == 1)
                <div class="alert alert-warning" role="alert">
                    You can't update because this bulletin is created by {{$bulletin->author->name}}
                </div>
                @endif
                <div class="row justify-content-center push">
                    <div class="col-md-10">
                        <div class="form-group mt-3">
                            <label> Title</label>
                            <input type="text" name="title" class="form-control mb-2 text-capitalize" value="{{$bulletin->title}}" {{$bulletin->author_id == auth()->user()->id || auth()->user()->role == 2 ? '' : 'disabled'}}>
                        </div>

                    </div>
                </div>
            </div>
            <div class="block-content">
                <div class="row justify-content-center push">
                    <div class="col-md-10">
                        <div class="form-group mt-3">
                            <label> Visibility</label>
                            <select class="form-control" name="published" id="published" {{$bulletin->author_id == auth()->user()->id ||  auth()->user()->role == 2 ? '' : 'disabled'}}>
                                <option value="{{0}}" {{$bulletin->published ==0 ? 'selected' : ''}}>Unpublished</option>
                                <option value="{{1}}" {{$bulletin->published ==1 ? 'selected' : ''}}>Published</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content">
                <div class="row justify-content-center push">
                    <div class="col-md-10">
                        <div class="form-group mt-3">
                            <label> Author</label>
                            <input type="text" class="form-control mb-2 text-capitalize" value="{{$bulletin->author->name}}" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content bg-body-light">
                <div class="row justify-content-center push">
                    <div class="col-md-10">
                        <button type="submit" class="btn btn-alt-primary">
                            <i class="fa fa-fw fa-check opacity-50 me-1"></i> Upate Bulletin
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>




</div>
{!! JsValidator::formRequest('App\Http\Requests\BulletinUpdateRequest', '#bulletin-update-form'); !!}

@endsection
