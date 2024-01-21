</main>
<!-- END Main Container -->

<!-- Footer -->
<footer id="page-footer" class="bg-body-light">

</footer>
<!-- END Footer -->
</div>
<!-- END Page Container -->


</body>
{{-- dashmix  --}}
<script src="{{asset('assets/js/dashmix.app.min.js')}}"></script>

{{-- Sweet alert --}}
<script src="{{asset('/assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>

{{-- toastr --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

{{-- CKeditor --}}
<script src="{{ asset('ckeditor-html/build/ckeditor.js') }}"></script>
{{-- <script src="{{ asset('inline-editor/build/ckeditor.js') }}"></script> --}}

{{-- select2 --}}
<script src="{{asset('/assets/plugins/select2/js/select2.min.js')}}"></script>

{{-- dropify --}}
<script src="{{asset('assets/js/dropify.min.js')}}"></script>

{{-- moment --}}
<script src="{{asset('assets/js/moment.js')}}"></script>


{{-- datatable --}}
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>

<script src="{{asset('assets/plugins/datatables-buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons-jszip/jszip.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons-pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons-pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/buttons.html5.min.js')}}"></script>

{{-- Sweet alert --}}
<script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>

{{-- js validation --}}

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\PasswordChangeRequest', '#my-form'); !!}
{!! JsValidator::formRequest('App\Http\Requests\ProfileUpdateRequest', '#profile-update-form'); !!}

<script>
    $(document).ready(function() {
        @if(Session::has('error'))
        toastr.error('{{ Session::get("error") }}', "Error", {}).css("width", "500px");
        @elseif(Session::has('success'))
        toastr.success('{{ Session::get("success") }}', 'Success ').css("width", "500px")
        @endif
    });

</script>

{{-- my custom js --}}
<script src="{{asset('js/main.js')}}"></script>


@yield('footer-scripts')

</html>
