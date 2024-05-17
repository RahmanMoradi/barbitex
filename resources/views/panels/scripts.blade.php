{{-- Vendor Scripts --}}
<script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
<script src="{{ asset('vendors/js/ui/prism.min.js') }}"></script>
@yield('vendor-script')
{{-- Theme Scripts --}}
<script src="{{ asset('js/core/app-menu.js') }}"></script>
<script src="{{ asset('js/core/app.js') }}"></script>
<script src="{{ asset('js/scripts/components.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ asset('js/scripts/extensions/toastr.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@if($configData['blankPage'] == false)
    <script src="{{ asset('js/scripts/customizer.js') }}"></script>
    <script src="{{ asset('js/scripts/footer.js') }}"></script>
@endif
<script src="{{asset('js/app.js')}}"></script>
<script>
    function copyToClipboard(element) {
        var $temp = $('<input>');
        $('body').append($temp);
        if ($(element).val() != "")
            $temp.val($(element).val()).select();
        else
            $temp.val($(element).find('span').html()).select();
        document.execCommand('copy');
        $temp.remove();
        $(element).attr('data-original-title', 'کپی شد');
        $('.tooltip-inner').html('کپی شد');
    }
</script>
<script>
    window.addEventListener('closeModal', (e) => {
        $('.closeModal').click();
    })
    window.addEventListener('openEditModal', (e) => {
        $('.editModal').modal('show');
    })
    window.addEventListener('showModal', (e) => {
        $('#showModal').click();
    })
    window.addEventListener('changeTheme', (e) => {
        if (e.detail === 'dark') {
            $('body').addClass('dark-layout')
            $('.header-navbar').addClass('navbar-dark')
            $('.main-menu').addClass('menu-dark')
            $('.main-menu').removeClass('menu-light')
        } else {
            $('body').removeClass('dark-layout')
            $('.header-navbar').removeClass('navbar-dark')
            $('.main-menu').removeClass('menu-dark')
            $('.main-menu').addClass('menu-light')

        }
    })
    window.addEventListener('clearImage', (e) => {
        $("input:file").val('');
    })
</script>
<livewire:flash-container/>
{{--@include('flash::message')--}}
{{--<script type="text/javascript">--}}
{{--    function googleTranslateElementInit() {--}}
{{--        new google.translate.TranslateElement({--}}
{{--            pageLanguage: 'fa',--}}
{{--            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,--}}
{{--            includedLanguages: "ar,en,tr"--}}
{{--        }, 'google_translate_element');--}}
{{--    }--}}
{{--</script>--}}

{{--<script type="text/javascript"--}}
{{--        src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>--}}
@if (isset(\App\Helpers\Helper::modules()['firebase']) && \App\Helpers\Helper::modules()['firebase'])
    @auth()
        @include('Firebase.firebase')
    @endauth
@endif
@stack('scripts')
@yield('myscript-chart')
@include('auth.errors')
