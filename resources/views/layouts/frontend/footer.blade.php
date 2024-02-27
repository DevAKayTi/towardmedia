</div>
<hr />
<footer class="container py-1">
    <div class="row d-flex align-items-center pb-3">
        <div class="col-md-6 text-center text-md-start py-3">
            <span>&copy; <span id="currentYear"></span> towardsmedia.com.</span>
            <a class="d-inline-block text-decoration-none link-danger mx-1" href="{{route('privacy-policy')}}">Privacy & Policy</a>
        </div>

        <div class="col-md-6 text-center text-md-end">
            <a href="https://www.facebook.com/sithojournal/" class="d-inline-flex align-items-center justify-content-center mx-1 ms-md-1 btn btn-danger rounded-circle" style="height: 45px;width:45px;"><span class="fab fa-facebook-f"></span></a>
            <a href="https://t.me/towardsweeklynews" class="d-inline-flex align-items-center justify-content-center mx-1 ms-md-1 btn btn-danger rounded-circle" style="height: 45px;width:45px;"><span class="fab fa-telegram-plane"></span></a>
            <a href="https://www.soundcloud.com/towards-podcast" class="d-inline-flex align-items-center justify-content-center mx-1 ms-md-1 btn btn-danger rounded-circle" style="height: 45px;width:45px;"><span class="fab fa-soundcloud"></span></a>
        </div>
    </div>
</footer>
<!-- end footer-->
<script src="{{asset('assets/frontend/plugin/jquery.min.js')}}"></script>
<script src="{{asset('assets/frontend/plugin/bootstrap/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/frontend/plugin/fontawesome/js/all.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#carouselExampleIndicators').carousel({
            interval: 2000
        });
    });

    const currentYear = new Date().getFullYear();
        $('#currentYear').text(currentYear);

</script>
</body>

</html>
