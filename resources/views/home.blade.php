@extends('layouts.backend.master')

@section('content')

<div class="bg-image" style="background-image: url('/assets/bg_dashboard.jpg');">
    <div class="bg-primary-dark-op">
        <div class="content content-full">
            <div class="row my-3">
                <div class="col-md-6 d-md-flex align-items-md-center">
                    <div class="py-4 py-md-0 text-center text-md-start">
                        <h1 class="fs-2 text-white mb-2">Dashboard</h1>
                        <h2 class="fs-lg fw-normal text-white-75 mb-0">Welcome to your overview</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">

    <div class="row">
        <div class="col-md-6 col-xl-4">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full">
                    <div class="d-flex align-items-center justify-content-between p-3">
                        <div class="me-3">
                            <p class="text-muted mb-0">
                                Authors
                            </p>
                            <p class="fs-3 mb-0">
                                {{$authorCount}}
                            </p>
                        </div>

                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-4">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full">
                    <div class="d-flex align-items-center justify-content-between p-3">
                        <div class="me-3">
                            <p class="text-muted mb-0">
                                Views
                            </p>
                            <p class="fs-3 mb-0">
                                {{$allViewCounts}}
                            </p>

                        </div>

                    </div>
                </div>
            </a>
        </div>
        @if ($mostViewedPost !==null)
        <div class="col-md-6 col-xl-4">
            <a class="block block-rounded block-link-pop" href="{{route('blogs.show',$mostViewedPost->id)}}">
                <div class="block-content block-content-full">
                    <div class="d-flex align-items-center justify-content-between p-1">
                        <div class="me-3">
                            <p class="text-muted mb-0">
                                Most Viewed Post
                            </p>
                            <p class="fs-3 mb-0">
                                {{$mostViewedPost->title}}
                            </p>
                            <span>
                                {!! \Illuminate\Support\Str::limit($mostViewedPost->description, 20 ) !!}
                            </span>
                        </div>

                    </div>
                </div>
            </a>
        </div>
        @endif
    </div>

    <div class="block block-rounded mt-3">

        <div class="block-header block-header-default">
            <h3 class="block-title">Activities</h3>

        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered  table-vcenter table-hover">
                    <thead>
                    <tr>
                        <th>Log</th>
                        <th>Event</th>
                        <th>Author</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($activities as $action)
                    <tr class='clickable-row' data-id="{{$action->id}}">
                        <td class=" text-capitalize">{{$action->log_name}}</td>
                        <td class=" text-capitalize">{{$action->event}}</td>
                        <td class=" text-capitalize">{{$action->causer->name}}</td>
                        <td>{{$action->description}}</td>
                        <td>{{\Carbon\Carbon::parse($action->created_at)->diffForHumans()}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- activity modal --}}
        @include('layouts.modals.activity')
        {{-- ip modal --}}
        @include('layouts.modals.ip')
        <div class="m-3 p-3 ">
            {{$activities->links()}}
        </div>
    </div>

</div>
@endsection
@section('footer-scripts')
<script>
    $(document).ready(function () {

        let activity, ip;
        $(document).on('click', '.clickable-row', function () {

            const id = $(this).data("id");
            $.ajax({
                type: "GET"
                , url: "/admin/activities/" + id
                , success: function (response) {
                    if (response.success) {
                        activity = response.activity
                        ip = response.ip
                        let {
                            log_name
                            , event
                            , description
                            , created_at
                        } = activity;
                        $('#activit-title').text(`${log_name}  ${event}`);
                        $("#log-name").val(`${log_name}`);
                        $("#event").val(`${event}`);
                        $("#description").val(`${description}`);
                        $("#date").val(moment(created_at).format('LLLL'));

                        if (!$('#deletedTitle-row').hasClass('d-none')) {
                            $('#deletedTitle-row').addClass('d-none');
                        }

                        if (log_name === 'post' && event !== 'deleted') {
                            if (response.activity.subject !== null) {
                                $('#already-delete-post').addClass('d-none');
                                $('#desc-href').removeClass('d-none');
                                $('#desc-href').text(`Show ${event} ${log_name}`);
                                $('#desc-href').attr('href', '/admin/blogs/' + response.activity.subject_id);
                            } else {
                                $('#desc-href').addClass('d-none');
                                $('#already-delete-post').removeClass('d-none')
                            }

                        } else {
                            $('#desc-href').addClass('d-none');
                            $('#already-delete-post').addClass('d-none')
                        }

                        if (event == 'deleted') {
                            $('#deletedTitle').val(response.deletedItem.title);
                            $('#deletedTitle-row').removeClass('d-none');
                        }

                        if (event == 'login success') {
                            $('#ip-row').removeClass('d-none');
                            let {
                                ip
                            } = response.activity.properties;
                            $('#ip').val(`${ip}`);
                        } else {
                            $('#ip-row').addClass('d-none');
                        }


                        $('#modal-block-popout').modal('show');
                    }
                }
            });
        })

        $(document).on('click', '#showIpInfo', function () {
            $('#modal-block-popout').modal('hide');

            let url = `https://ipinfo.io/${ip}/json?token=a79216a0d7484a`;
            Dashmix.loader('show', 'bg-primary')
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    let {
                        country
                        , region
                        , city
                        , org
                        , ip
                    } = data;
                    $('#ipAddress').val(ip);
                    $('#country').val(country);
                    $('#region').val(region);
                    $('#city').val(city);
                    $('#isp').val(org);
                    Dashmix.loader('hide')
                    $('#ip-info-modal').modal('show');
                })
                .catch(err => {
                    Dashmix.loader('hide')
                    console.error(err);
                    toastr.error('Please Deactivate Your AD Block Extensions', 'ERROR!').css("width", "500px")
                });
        });
        $(document).on('click', '#showActivityInfo', function () {
            $('#modal-block-popout').modal('show');
            $('#ip-info-modal').modal('hide');
        });
    });

</script>
@endsection
