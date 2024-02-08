@extends('layouts.backend.master')
@section('content')
<div class="content">
    <div class="content content-full content-boxed">
        <!-- New Post -->
        <form action="{{route('bulletins.store')}}" method="POST" id="store-volue-form">
            @csrf
            <div class="block">
                <div class="block-header block-header-default">
                    <a class="btn btn-alt-secondary" href="{{route('bulletins.index')}}">
                        <i class="fa fa-arrow-left me-1"></i> Manage Bulletins
                    </a>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center push">
                        <div class="col-md-10">
                            <div class="mb-4">
                                <label class="form-label" for="dm-post-add-title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter a title.." value="{{ old('title') }}">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center push">
                        <div class="col-md-10">
                            <select class="form-select @error('published') is-invalid @enderror" id="published" name="published">
                                <option value="{{1}}">Published</option>
                                <option value="{{0}}" selected>Unpublished</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="block-content bg-body-light">
                    <div class="row justify-content-center push">
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-alt-primary">
                                <i class="fa fa-fw fa-check opacity-50 me-1"></i> Create Bulletin
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- END New Post -->
    </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\StoreBulletinRequest', '#store-volue-form'); !!}

@endsection
