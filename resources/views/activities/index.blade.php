@extends('layouts.backend.master')
@section('css')
<style>
    tr:hover {
        cursor: pointer;
    }

</style>
@endsection
@section('content')
<div class="container">
    <div class="block block-rounded mt-3">

        <div class="block-header block-header-default">
            <h3 class="block-title">Your Activities</h3>

        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered  table-vcenter table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($actions as $action)
                        <tr class='clickable-row' data-id="{{$action->id}}">
                            <td class=" text-capitalize">{{$action->log_name}} {{$action->event}}</td>
                            <td>{{$action->description}}</td>
                            <td>{{\Carbon\Carbon::parse($action->created_at)->diffForHumans()}}</td>
                        </tr>
                        @endforeach
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- activity modal --}}
    @include('layouts.modals.activity')
    {{-- ip modal --}}
    @include('layouts.modals.ip')
    {{$actions->links()}}
</div>
@endsection
@section('footer-scripts')
<script>
    $(document).ready(function() {

        let activity, ip;
        $(document).on('click', '.clickable-row', function() {

            const id = $(this).data("id");
            $.ajax({
                type: "GET"
                , url: "/admin/activities/" + id
                , success: function(response) {
                    console.log(response);
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
                    } else {
                        toastr.error(response.error, 'ERROR!').css("width", "500px")
                    }
                }
            });
        })

        $(document).on('click', '#showIpInfo', function() {
            $('#modal-block-popout').modal('hide');

            let url = 'https://ipinfo.io/66.87.125.72/json?token=a79216a0d7484a';
            if (ip !== '127.0.0.1') {
                url = 'https://ipinfo.io/' + ip + '/json?token=a79216a0d7484a';
            }
            console.log(url);
            Dashmix.loader('show', 'bg-primary')
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log(data)
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
                    console.log(err);
                    toastr.error('Please Deactivate Your AD Block Extensions', 'ERROR!').css("width", "500px")
                });
        });
        $(document).on('click', '#showActivityInfo', function() {
            $('#modal-block-popout').modal('show');
            $('#ip-info-modal').modal('hide');
        });
    });

</script>
@endsection
