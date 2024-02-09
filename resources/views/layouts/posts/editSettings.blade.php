<div class="col-md-4 col-lg-5 col-xl-3 order-md-1 bg-body-extra-light">
    <div class="content p-0">
        <div id="side-content" class="d-none d-md-block push">
            <div id="settings-accordion" role="tablist" aria-multiselectable="true">
                <div class="block mb-0">
                    <div class="block-header bg-body p-0" role="tab" id="settings-accordion_h1">
                        <a class="fw-semibold d-block w-100 p-3" data-bs-toggle="collapse" data-bs-parent="#settings-accordion" href="#settings-accordion_s1" aria-expanded="true" aria-controls="settings-accordion_s1">Status &amp; Visibility</a>
                    </div>
                    <div id="settings-accordion_s1" class="collapse show" role="tabpanel" aria-labelledby="settings-accordion_h1" data-bs-parent="#settings-accordion">
                        <div class="block-content">
                            <div class="row mb-4">
                                <label class="col-sm-4 col-form-label">Type</label>
                                <div class="col-sm-8">
                                    <select class="form-select form-control @error('type') is-invalid @enderror" id="type" name="type">
                                        <option value={{null}}> Choose Type</option>
                                        @foreach ($types as $type)
                                        @if ($post->type->id == $type->id)
                                        <option value="{{$type->id}}" selected>{{ $type->name }}</option>
                                        @else
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4 " id="volume-row">
                                <label class="col-sm-4 col-form-label">Volume</label>
                                <div class="col-sm-8">
                                    <select class="form-select form-control @error('volume') is-invalid @enderror" id="volume" name="volume">
                                        <option value={{null}}> Choose Volume</option>
                                        @foreach ($volumes as $volume)

                                        @if ($post->volume !== null)
                                        @if ($post->volume->id == $volume->id)
                                        <option value="{{$volume->id}}" selected>{{ $volume->title }}</option>
                                        @else
                                        <option value="{{$volume->id}}">{{$volume->title}}</option>
                                        @endif

                                        @else
                                        <option value="{{$volume->id}}">{{$volume->title}}</option>

                                        @endif

                                        @endforeach
                                    </select>
                                    @error('volume')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4 d-none " id="bulletin-row">
                                <label class="col-sm-4 col-form-label">Volume</label>
                                <div class="col-sm-8">
                                    <select class=" form-control @error('bulletin') is-invalid @enderror" id="bulletin" name="bulletin" style="width: 100%;">
                                        @foreach ($bulletins as $bulletin)
                                        @if (old('bulletin') == $bulletin->id)
                                        <option value="{{$bulletin->id}}" selected>{{ $bulletin->title }}</option>
                                        @else
                                        <option value="{{$bulletin->id}}">{{$bulletin->title}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                {{-- {{$errors}} --}}
                                <label class="col-sm-4 col-form-label">Visibility</label>
                                <div class="col-sm-8">
                                    <select class="form-select @error('published') is-invalid @enderror" id="published" name="published">
                                        <option value="{{1}}" @if($post->published == 1) selected @endif>Published</option>
                                        <option value="{{0}}" @if($post->published == 0 ) selected @endif>Unpublished</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <label class="col-sm-4 col-form-label" for="example-wp-author">Author</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="{{$post->author->name}}" disabled />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="block mb-0">
                    <div class="block-header bg-body border-top p-0" role="tab" id="settings-accordion_h3">
                        <a class="fw-semibold d-block w-100 p-3" data-bs-toggle="collapse" data-bs-parent="#settings-accordion" href="#settings-accordion_s3" aria-expanded="true" aria-controls="settings-accordion_s3">Tags</a>
                    </div>
                    <div id="settings-accordion_s3" class="collapse" role="tabpanel" aria-labelledby="settings-accordion_h3" data-bs-parent="#settings-accordion">
                        <div class="block-content">
                            <div class="mb-4">
                                <label class="form-label" for="example-wp-tags">Add New Tags</label>


                                <select class=" tags @error('tags') is-invalid @enderror" name="tags[]" multiple="multiple" style="width: 100%;">
                                    @foreach ($tags as $tag)
                                    <option value="{{$tag->id}}" @if($post->tags->contains($tag)) selected @endif>{{$tag->name}}</option>
                                    @endforeach
                                </select>
                                @error('tags')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                        </div>
                    </div>
                </div>
                <div class="block mb-0">
                    <div class="block-header bg-body border-top p-0" role="tab" id="settings-accordion_h4">
                        <a class="fw-semibold d-block w-100 p-3" data-bs-toggle="collapse" data-bs-parent="#settings-accordion" href="#settings-accordion_s4" aria-expanded="true" aria-controls="settings-accordion_s4">Featured Image </a>
                    </div>
                    <div id="settings-accordion_s4" class="collapse" role="tabpanel" aria-labelledby="settings-accordion_h4" data-bs-parent="#settings-accordion">
                        <div class="block-content">
                            <div class="mb-4">
                                <input type="file" class="form-control dropify " data-max-file-size="5M" name="featuredImage" id="featuredImage" data-default-file="{{ url('storage/uploads/featured/'.$post->post_thumbnail)}}" />
                                @error('featuredImage')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Settings -->
    </div>
</div>
