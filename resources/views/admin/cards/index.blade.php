@extends('layouts/contentLayoutMaster')

@section('title', trans('list of bank cards'))

@section('vendor-style')
    <!-- vednor css files -->
    <link rel="stylesheet" href="{{ asset('vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/extensions/tether-theme-arrows.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/extensions/tether.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/extensions/shepherd-theme-default.css') }}">
@endsection
@section('mystyle')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset('css/pages/dashboard-analytics.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/card-analytics.min.css') }}">
    {{--    <link rel="stylesheet" href="{{ asset('css/plugins/tour/tour.min.css') }}">--}}
@endsection

@section('content')
    <livewire:admin.user.cards/>
    <!-- Modal -->
    <button type="button" id="inquiryCallbackBtn" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#inquiryModal" data-toggle="modal" data-target="#inquiryModal">
    </button>
    <div class="modal bd-example-modal-lg" tabindex="-1" role="dialog" id="inquiryModal" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">نتیجه استعلام</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>بانک</th>
                            <td id="bank"></td>
                        </tr>
                        <tr>
                            <th>شماره شبا</th>
                            <td id="iban"></td>
                        </tr>
                        <tr>
                            <th>نام و نام خانوادگی</th>
                            <td id="fullName"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
    <!-- vednor files -->
    <script src="{{ asset('vendors/js/charts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('vendors/js/extensions/tether.min.js') }}"></script>
    {{--    <script src="{{ asset('vendors/js/extensions/shepherd.min.js') }}"></script>--}}
@endsection
@section('myscript')
    <script src="{{ asset('vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/scripts/datatables/datatable.js') }}"></script>
    <!-- Page js files -->
    <script src="{{ asset('js/scripts/pages/dashboard-analytics.js') }}"></script>
    <script>
        function submitForm(action, id) {
            console.log(11)
            $('#action').val(action)
            $('#card_id').val(id)
            $('#formCardStatus').submit()
        }
    </script>

    <script>
        window.addEventListener('callbackInquiry', function (event) {
            var type = event.detail.type
            var response = event.detail.response

            if (type === 'iban') {
                $('#iban').text(response['value'])
                $('#fullName').text(response['ibanInfo']['owners'][0]['firstName'] + ' ' + response['ibanInfo']['owners'][0]['lastName'])
                $('#bank').text(response['cardInfo']['bank'])
            } else {
                $('#iban').text(response['cardNumber'])
                $('#fullName').text(response['name'])
                $('#bank').text(response['bank'])
            }
            $('#inquiryCallbackBtn').click()
        })
    </script>
@endsection
