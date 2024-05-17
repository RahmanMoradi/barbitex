<template>
    <div class="card" style="height: 455px;">
        <div class="card-header">
            <h3 class="card-title font-medium-1">خریداران</h3>
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

                <tr v-for="(buyer, name, index) in buyers" class="cursor-pointer" @click="setAmount(buyer[0],name)"
                        :style="'background-color: none;background-image: linear-gradient(90deg,rgba(108,215,131,0.1)'+buyer[1]+'%, #fff0 0%, rgb(255 255 255 / 0%) 0%)'">
                    <td class="p-0 font-small-2" style="text-align: right">{{ buyer[0] }}</td>
                    <td class="p-0 font-small-2 text-success" style="text-align: left">{{ name }}</td>
                </tr>
                </tbody>
            </table>
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
        channelprefix:{
            required: true,
            type: String
        }
    },
    data: function () {
        return {
            buyers: [],
        }
    },
    methods: {
        setAmount: function (qty,amount) {
            window.postMessage([qty,amount,'sell'])
        },
    },
    created() {
        Echo.channel(`${this.channelprefix}ask-bid-channel-${this.market.symbol}`).listen(".AskBid", e => {
            if (e.bids) {
                this.buyers = e.bids
            }
        });
    },
}
</script>

<style scoped>

</style>
