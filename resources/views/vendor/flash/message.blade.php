<div>
    @if($shown)
        <script>
            $(document).ready(function () {
                toastr.{{$styles['bg-color']}}(`{!! $message['message'] !!}`, '', {
                    "progressBar": true,
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut",
                    "timeOut": `{{$message['important'] ? 0 : 3000}}`
                });
            })
        </script>
    @endif
</div>
