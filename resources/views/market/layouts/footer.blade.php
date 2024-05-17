<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light navbar-shadow">
    <p class="clearfix blue-grey lighten-2 mb-0">
        <span class="float-md-left d-block d-md-inline-block mt-25">حقوق کپی رایت &copy; 1399
            <a class="text-bold-800 grey darken-2" href="https://webazin.net" target="_blank"> وب آذین </a>کلیه حقوق محفوظ است
        </span>
        <span class="float-md-right d-none d-md-block">دست ساز و ساخته شده با<i
                class="feather icon-heart pink"></i></span>
        <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
    </p>
</footer>
<!-- END: Footer-->


<!-- BEGIN: Vendor JS-->
<script src="/panelAssets/app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="/panelAssets/app-assets/vendors/js/ui/jquery.sticky.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="/panelAssets/app-assets/js/core/app-menu.min.js"></script>
<script src="/panelAssets/app-assets/js/core/app.min.js"></script>
<script src="/panelAssets/app-assets/js/scripts/components.min.js"></script>
<script src="/panelAssets/app-assets/js/scripts/customizer.min.js"></script>
<script src="/panelAssets/app-assets/js/scripts/footer.min.js"></script>
<script src="/panelAssets/app-assets/vendors/js/extensions/nouislider.min.js"></script>
<script src="/panelAssets/app-assets/js/scripts/extensions/noui-slider.min.js"></script>
<script src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ asset('js/scripts/extensions/toastr.js') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="/panelAssets/app-assets/js/scripts/pages/faq-kb.min.js"></script>
<!-- END: Page JS-->
<script src="{{asset('/js/app.js')}}" defer></script>
<script src="{{asset('/js2/app.js')}}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"
        integrity="sha512-zMfrMAZYAlNClPKjN+JMuslK/B6sPM09BGvrWlW+cymmPmsUT1xJF3P4kxI3lOh9zypakSgWaTpY6vDJY/3Dig=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {
        $(".nicescrol").niceScroll();
        window.addEventListener('changeTheme', (e) => {
            location.reload()
        })
    });
</script>
@livewireScripts
<livewire:flash-container/>
@yield('js')
</body>
<!-- END: Body-->
</html>
