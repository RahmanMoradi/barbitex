<template>
    <div class="card" style="height: 440px">
        <div class="card-header">
            <h3 class="card-title font-medium-1">فروشندگان</h3>
        </div>
        <div class="card-body nicescrol">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="text-muted" style="text-align: right">مقدار({{this.market.currency_buyer.symbol}})</th>
                    <th class="text-muted" style="text-align: left">واحد({{this.market.currency_seller.symbol}})</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(seller, name, index) in sellers" class="cursor-pointer" @click="setAmount(seller[0],name)"
                    :style="'background-color: none;background-image: linear-gradient(90deg,rgba(182,54,71,0.1)'+seller[1]+'%, #fff0 0%, rgb(255 255 255 / 0%) 0%)'">
                    <td class="p-0 font-small-2" style="text-align: right">{{ seller[0] }}</td>
                    <td class="p-0 font-small-2 text-danger" style="text-align: left">{{ name }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "Seller",
    props: {
        market: {
            required: true,
            type: Object
        },
        channelprefix:{
            required: true,
            type: String
        }
    },
    data: function () {
        return {
            sellers: [],
        }
    },
    methods: {
        setAmount: function (qty,amount) {
            window.postMessage([qty,amount,'buy'])
        },
    },
    created() {
        Echo.channel(`${this.channelprefix}ask-bid-channel-${this.market.symbol}`).listen(".AskBid", e => {
            if (e.asks) {
                this.sellers = e.asks
            }
        });
    },
}
</script>

<style scoped>

</style>
