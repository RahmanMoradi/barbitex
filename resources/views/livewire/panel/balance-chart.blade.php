@section('mystyle-chart')
    <link rel="stylesheet" href="{{ asset('panelAssets/app-assets/vendors/css/charts/apexcharts.css') }}">
@endsection
<div>
    <section id="component-swiper-centered-slides">
        <div class="card shadow-none">
            <div class="card-header">
                <h4 class="card-title">موجودی</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div id="pie-chart" class="height-250"></div>
                </div>
            </div>
        </div>
    </section>
</div>
@section('myscript-chart')
    <script src="{{asset('panelAssets/app-assets/vendors/js/charts/echarts/echarts.js')}}"></script>
    <script>
        // $('#price').digitbox({separator: ',', grouping: 1, truevalue: 1});
        var balance = `{!! json_encode($balance) !!}`;
        var balance = JSON.parse(balance);

        var pieChart = echarts.init(document.getElementById('pie-chart'));
        var dataName = [];
        var dataData = [];
        for (var i = 0; balance.length > i; i++) {
            dataName.push(balance[i].currency)
            dataData[i] = {
                'name': balance[i].currency,
                'value': balance[i].balanceIrt,
            }
        }
        var pieChartoption = {
            tooltip: {
                trigger: 'item',
                formatter: function (params) {
                    return params.data.name + '(' + params.percent + '%)' + ':<br>' +
                        String(params.data.value).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' تومان '
                },
                textStyle: {
                    fontFamily: "IRANSans,Montserrat, Helvetica, Arial, serif",
                },
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                data: dataName
                ,
                textStyle: {
                    fontFamily: "IRANSans,Montserrat, Helvetica, Arial, serif",
                },
            },
            series: [
                {
                    label: {
                        textStyle: {
                            fontFamily: "IRANSans,Montserrat, Helvetica, Arial, serif",
                        },
                        formatter: "{b} ({d}%)",
                    },
                    name: 'موجودی',
                    type: 'pie',
                    radius: '80%',
                    center: ['50%', '60%'],
                    color: ['#388E3C', '#1DE9B6', '#9C27B0', '#009688', '#FFC107', '#D84315', '#C2185B', '#B39DDB', '#00B0FF', '#d50000'],
                    data: dataData
                    ,
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    },

                }],
        };
        pieChart.setOption(pieChartoption);
    </script>
@endsection
