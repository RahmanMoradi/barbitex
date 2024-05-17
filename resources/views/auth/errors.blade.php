@if ($errors->any())
    <script>
        @foreach ($errors->all() as $error)
        $(document).ready(function () {
            toastr.error(`{!! $error !!}`, '', {
                "progressBar": true,
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "timeOut": '0'
            });
        })
        @endforeach
    </script>
@endif
