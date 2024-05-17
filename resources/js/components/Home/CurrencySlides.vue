<template>
    <div class="row mt-50 mb-0 full-width" style="background: #161e32">
        <div class="d-flex">
            <div v-for="item in marketList" class="col-md-2 col-xs-6 border-1px pr-20 pl-20 pt-5"
                 style="border-color: #343d56 !important;display: inline-flex;justify-content: space-around">
                <div>
                    <p class="text-white font-15 font-weight-bold">{{ item['symbol'] }}</p>
                    <p class="font-18 font-weight-bold">{{ item['price'] |formatNumber(getDecimal(item.decimal)) }}</p>
                    <p :class="['font-15', item['change_24'] >0 ? 'text-success':'text-danger']">
                        {{ item['change_24'] }}%
                    </p>
                </div>
                <div>
                    <p v-if="marketnamefa" style="color:#161e32">
                        {{ item['currency_buyer']['name'] }}
                    </p>
                    <p v-else>
                        {{ item['symbol'] }}
                    </p>
                    <img height="30" :src="item['currency_buyer']['chart_image']">
                    <p style="color:#161e32 ">PRICE</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
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
            }
        });
    },
}
</script>

<style scoped>

</style>
