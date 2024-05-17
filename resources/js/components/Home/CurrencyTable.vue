<template>
    <section class="inner-header divider parallax overlay-white-8">
        <div class="container pt-60 pb-60">
            <!-- Section Content -->
            <div class="section-content">
                <div class="row">
                    <div class="diamond-line-centered-theme-colored2"></div>
                    <div class="col-md-12 text-center table-responsive">
                        <table class="table table-striped table-hover text-right">
                            <thead>
                            <tr>
                                <th>نوع ارز</th>
                                <th></th>
                                <th>آخرین قیمت / دلار</th>
                                <th>آخرین قیمت / تومان</th>
                                <th>تغییرات</th>
                                <th v-if="homechart">چارت</th>
                                <th>معامله</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="market in marketList" class="p-1">
                                <th>
                                    <img height="30" :src="market['currency_buyer']['iconUrl']"
                                         :alt="market['symbol']">
                                </th>
                                <th>
                                    <p v-if="marketnamefa">
                                        {{ market['currency_buyer']['name'] }} ({{
                                            market['currency_buyer']['symbol']
                                        }})
                                    </p>
                                    <p v-else>
                                        {{ market['symbol'] }}
                                    </p>
                                </th>
                                <th>
                                    {{ market['price'] | formatNumber(getDecimal(market['decimal'])) |noE }}$
                                </th>
                                <th>
                                    <span>خرید از ما:</span>
                                    {{ market['currency_buyer']['send_price'] | formatNumber(getDecimal(market['decimal'])) }}
                                    تومان
                                    <hr style="margin-top: 6px;margin-bottom: 6px;">
                                    <span>فروش به ما:</span>
                                    {{ market['currency_buyer']['receive_price'] | formatNumber(getDecimal(market['decimal'])) }}
                                    تومان
                                </th>
                                <th>
                                    <span
                                        :class="['badge badge-pill',market['change_24'] < 0 ? 'text-danger badge-danger' : 'text-success badge-success']"
                                        style="direction: ltr;height: 25px;justify-content: center;display: flex;align-items: center;">
                                        {{ market['change_24'] }}%
                                    </span>
                                </th>
                                <td v-if="homechart">
                                    <img height="30" :src="market['currency_buyer']['chart_image']">
                                </td>
                                <th>
                                    <a :href="'/market/'+market['symbol']" class="btn btn-default">معامله</a>
                                </th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "CurrencyTable",
    props: {
        markets: {
            required: true,
            type: Object
        },
        channelprefix: {
            required: true,
            type: String
        },
        marketnamefa: {
            required: true,
            type: Boolean
        },
        homechart: {
            required: true,
            type: Boolean
        },
        usdtsell: {
            required: true,
            type: Number
        },
        sellpercent: {
            required: true,
            type: Number
        },
        usdtbuy: {
            required: true,
            type: Number
        },
        buypercent: {
            required: true,
            type: Number
        }
    },
    data: function () {
        return {
            marketList: {},
        }
    },
    methods: {
        getDecimal: function (decimal) {
            var newDecimal = '0.0'
            for (var i = 0; i < decimal; i++) {
                newDecimal += '0';
            }
            return newDecimal;
        }
    },
    created() {
        this.marketList = this.markets
        Echo.channel(`${this.channelprefix}ticker-update-channels`).listen(".App\\Events\\Binance\\GetTicker", e => {
            e = JSON.parse(e)
            var item = this.marketList.filter(function (market) {
                return market.symbol.includes(e.symbol);
            });
            if (item.length > 0) {
                item[0].price = e.close
                item[0].change_24 = e.percentChange
                var sellPrice = e.close * this.usdtsell;
                var sellPrice = ((sellPrice * this.sellpercent) / 100 + sellPrice)
                item[0]['currency_buyer']['receive_price'] = sellPrice

                var buyPrice = e.close * this.usdtbuy;
                var buyPrice = ((buyPrice * this.buypercent) / 100 + buyPrice)
                item[0]['currency_buyer']['send_price'] = buyPrice
            }
        });
    },
}
</script>

<style scoped>

</style>
