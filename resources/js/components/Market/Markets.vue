<template>
    <div class="card" style="height: 455px">
        <div class="card-header">
            <div class="col-12 d-flex justify-content-between align-content-center">
                <h3 class="card-title font-medium-1 col-4">بازارها</h3>
                <input type="text" class="form-control form-control-sm col-8" v-model="search" @keyup="filter">
            </div>
        </div>
        <div class="card-body nicescrol" style="overflow-y: scroll">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>نماد</th>
                    <th>قیمت</th>
                    <th>تغییر</th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="item in marketList" @click="changeMarket(item.symbol)"
                    class="cursor-pointer border-bottom">
                    <td class="p-0 font-small-3">
                        <i class="fa fa-dot-circle-o" v-if="item.symbol === market.symbol"></i>
                        {{ item.symbol }}
                    </td>
                    <td style="width: 30px; display: inline-flex;white-space: nowrap;"
                        :class="['p-0 font-small-2 text-black pt-1', item.change_24 > 0 ? 'text-success' :(item.change_24 < 0 ? 'text-danger' :'text-secondary')]">
                        {{ item.price |noE }}
                    </td>
                    <td class="p-1 font-small-3">
                        <span
                            :class="['badge badge-sm block text-black black' ,item.change_24 > 0 ? 'badge-light-success' :(item.change_24 < 0 ? 'badge-light-danger' :'badge-light-secondary')]">
                            {{ item.change_24 }}
                            %
                        </span>
                    </td>
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
        markets: {
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
            marketList: {},
            search: ''
        }
    },
    methods: {
        changeMarket: function (symbol) {
            window.location.href = '/market/' + symbol
        },
        filter: function () {
            if (this.search === '') {
                this.marketList = this.markets
            }
            let self = this
            var items = this.marketList.filter(function (market) {
                return market.symbol.indexOf(self.search.toUpperCase()) > -1;
            });
            this.marketList = items
        }
    },
    created() {
        this.marketList = this.markets
        Echo.channel(`${this.channelprefix}ticker-update-channels`).listen(".App\\Events\\Binance\\GetTicker", e => {
            e = JSON.parse(e)
            var item = this.marketList.filter(function (market) {
                return market.symbol.includes(e.symbol);
            });
            item[0].price = e.close
            item[0].change_24 = e.percentChange
        });
    },
}
</script>

<style scoped>

</style>
