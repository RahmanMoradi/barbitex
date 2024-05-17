<template>
    <div>
        <div class="card">
            <div class="card-body d-flex justify-content-between">
                <div class="font-medium-1 text-bold">{{ this.symbol }}</div>
                <div class="font-small-3">
                    تغییرات :
                    <span
                        :class="['text-bold',this.ticker.percentChange > 0 ? 'text-success' :(this.ticker.percentChange < 0 ? 'text-danger' :'')  ]">
                    {{ this.ticker.percentChange }}
                    </span>
                </div>
                <div class="font-small-3">بیشترین : {{ this.ticker.high }}</div>
                <div class="font-small-3">کمترین : {{ this.ticker.low }}</div>
                <div class="font-small-3">آخرین : {{ this.ticker.close }}</div>
                <div class="font-small-3">حجم : {{ this.ticker.volume | formatNumber }}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Buyer",
    props: {
        market: {
            required: true,
            type: Object
        },
        channelprefix: {
            required: true,
            type: String
        }
    },
    data: function () {
        return {
            symbol: '',
            ticker: {},
        }
    },
    mounted() {

    },
    created() {
        Echo.channel(`${this.channelprefix}ticker-update-channels`).listen(".App\\Events\\Binance\\GetTicker", e => {
            e = JSON.parse(e)
            if (e.symbol === this.market.symbol) {
                document.title = this.market.symbol + ' ' + e.close
                this.ticker = e
                this.symbol = e.symbol
            }
        });
    },
}
</script>

<style scoped>

</style>
