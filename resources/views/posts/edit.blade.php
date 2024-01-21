@extends('layouts.backend.master')
@section('css')

@endsection
@section('content')

<main id="main-container  ">
    <!-- Page Content -->
    <form action="{{route('blogs.update',$post->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        {{ method_field('PATCH') }}
        <div class="row g-0 flex-md-grow-1 ">
            @include('layouts.posts.editSettings')
            <div class="col-md-8 col-lg-7 col-xl-9 order-md-0 bg-body-dark">
                <!-- Main Content -->
                <div class="content">
                    <div class="block block-rounded">
                        <div class="block-content block-content-full d-flex justify-content-between border-bottom">
                            <div>
                                <a class="btn btn-alt-secondary" href="{{route('blogs.index')}}">
                                    <i class="fa fa-arrow-left me-1"></i> Manage Posts
                                </a>
                            </div>
                            <div>
                                <h1 class=" my-2 my-sm-3">Edit Blog Post</h1>
                            </div>
                            <div>
                                {{-- <a class="btn btn-sm btn-alt-info" href="javascript:void(0)">Preview</a> --}}
                                <input type="submit" value="Update" class="btn btn-sm btn-info" />
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="mb-4">
                                <input type="text" class="form-control py-4 @error('title') is-invalid @enderror" id="title" name="title" value="{{$post->title }}" placeholder="Add Title..">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <input type="text" class="form-control py-4 @error('description') is-invalid @enderror" id="description" name="description" value="{{$post->description }}" placeholder="Add description..">
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <textarea class="form-control @error('content') is-invalid @enderror" id="editor" placeholder="Enter content" name="content">
                                {{$post->content}}
                                </textarea>
                                @error('content')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Main Content -->
            </div>

        </div>
    </form>

    <!-- END Page Content -->
</main>
@endsection
@section('footer-scripts')

<script>
    $(document).ready(function() {
        $('.tags').select2({
            placeholder: ''
            , allowClear: true
            , tags: true
            , createTag: function(params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                return {
                    id: +$('.tags > option').length + 1
                    , text: term
                    , newTag: true
                }
            }
        });
        $('.tags').on('select2:select', function(e) {
            let tag = e.params.data;
            if (tag.newTag === true) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "Post"
                    , url: '/admin/storeTag'
                    , data: {
                        'tag': tag.text
                    }
                    , dataType: "json"
                    , success: function(response) {
                        if (response.success) {
                            toastr.info(" ", "New Category Created", {
                                iconClass: "toast-custom"
                            });
                        }
                    }
                });
            }
        });
        $('.tags').on('select2:unselect', function(e) {
            let tag = e.params.data;
            if (tag.newTag === true) {
                var data = {
                    id: tag.id
                    , text: tag.text
                };
                var newOption = new Option(data.text, data.id, false, false);
                $('.tags').append(newOption).trigger('change');
            }
        });
    });

    class MyUploadAdapter {

        constructor(loader) {
            // The file loader instance to use during the upload.
            this.loader = loader;
        }

        // Starts the upload process.
        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    this._initRequest();
                    this._initListeners(resolve, reject, file);
                    this._sendRequest(file);
                }));
        }

        // Aborts the upload process.
        abort() {
            if (this.xhr) {
                this.xhr.abort();
            }
        }

        // Initializes the XMLHttpRequest object using the URL passed to the constructor.
        _initRequest() {
            const xhr = this.xhr = new XMLHttpRequest();

            let csrf = document.querySelector('meta[name="csrf-token"]').content;
            // xhr.open('POST', "{{route('imageUpload',['_token'=>csrf_token()])}}", true);
            xhr.open('POST', `/admin/imageUpload?_token=${csrf}`, true);
            xhr.responseType = 'json';
        }

        // Initializes XMLHttpRequest listeners.
        _initListeners(resolve, reject, file) {
            const xhr = this.xhr;
            const loader = this.loader;
            const genericErrorText = `Couldn't upload file: ${file.name}.`;

            xhr.addEventListener('error', () => reject(genericErrorText));
            xhr.addEventListener('abort', () => reject());
            xhr.addEventListener('load', () => {
                const response = xhr.response;

                // This example assumes the XHR server's "response" object will come with
                // an "error" which has its own "message" that can be passed to reject()
                // in the upload promise.
                //
                // Your integration may handle upload errors in a different way so make sure
                // it is done properly. The reject() function must be called when the upload fails.
                if (!response || response.error) {
                    return reject(response && response.error ? response.error.message : genericErrorText);
                }

                // If the upload is successful, resolve the upload promise with an object containing
                // at least the "default" URL, pointing to the image on the server.
                // This URL will be used to display the image in the content. Learn more in the
                // UploadAdapter#upload documentation.

                resolve(response);
            });

            // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
            // properties which are used e.g. to display the upload progress bar in the editor
            // user interface.
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', evt => {
                    if (evt.lengthComputable) {
                        loader.uploadTotal = evt.total;
                        loader.uploaded = evt.loaded;
                    }
                });
            }
        }

        // Prepares the data and sends the request.
        _sendRequest(file) {
            // Prepare the form data.
            const data = new FormData();

            data.append('upload', file);

            // Important note: This is the right place to implement security mechanisms
            // like authentication and CSRF protection. For instance, you can use
            // XMLHttpRequest.setRequestHeader() to set the request headers containing
            // the CSRF token generated earlier by your application.

            // Send the request.
            this.xhr.send(data);
        }
    }

    // ...

    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            // Configure the URL to the upload script in your back-end here!
            return new MyUploadAdapter(loader);
        };
    }

    // ...

    // ClassicEditor.builtinPlugins.map(plugin => console.log(plugin.pluginName));

    ClassicEditor
        .create(document.querySelector('#editor'), {
            htmlSupport: {
                allow: [ // Enables plain <div> elements.
                    {
                        name: /^(div|section|article|a|iframe)$/
                        , attributes: true
                        , classes: true
                        , styles: true
                    }
                , ]
                , disallow: ['script']
            }
            , toolbar: ['heading', '|', 'bold', '|', 'italic', '|', 'link', '|', 'bulletedlist', '|', 'numberedlist', '|', 'imageUpload', '|', 'blockquote', '|', 'alignment', 'sourceEditing', ]
            , extraPlugins: [MyCustomUploadAdapterPlugin, 'GeneralHtmlSupport']
        })
        .catch(error => {
            console.log(error);
        });


    if ($('#type').val() == 2) {
        $('#volume-row').removeClass('d-none');
    } else {
        if (!$('#volume-row').hasClass('d-none'))
            $('#volume-row').addClass('d-none');
    }
    if ($('#type').val()) {

        if ($('#type').val() == 1 || $('#type').val() == 2) {
            $('#category-row').removeClass('d-none');
            $('#category option').each(function(index, val) {
                let type_id = $(this).data("type")
                if (type_id) {
                    if (type_id == $('#type').val()) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                    // $('#category').prop('selectedIndex', 0);
                }
            })
        } else {
            if (!$('#category-row').hasClass('d-none'))
                $('#category-row').addClass('d-none');
        }
    }
    $(document).on('change', '#type', function() {
        if ($(this).val() == 2) {
            $('#volume-row').removeClass('d-none');
        } else {
            if (!$('#volume-row').hasClass('d-none'))
                $('#volume-row').addClass('d-none');
        }

        //  for category row
        if ($(this).val() == 1 || $(this).val() == 2) {
            $('#category-row').removeClass('d-none');
            $('#category option').each(function(index, val) {
                let type_id = $(this).data("type")
                if (type_id) {
                    if (type_id == $('#type').val()) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                    $('#category').prop('selectedIndex', 0);
                }
            })
        } else {
            if (!$('#category-row').hasClass('d-none'))
                $('#category-row').addClass('d-none');
        }

    });

</script>

@endsection
