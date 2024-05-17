<template>
    <div class="card" style="height: 440px">
        <div class="card-header">
            <h3 class="card-title font-medium-1">آخرین معاملات</h3>
        </div>
        <div class="card-body nicescrol">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>تاریخ</th>
                    <th>قیمت</th>
                    <th style="float: left">مقدار</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="order in lastOrders">
                    <td class="p-0 font-small-3">{{ order.T | timeFormat }}</td>
                    <td :class="['p-0 font-small-3', order.m  ? 'text-danger' : 'text-success']">{{ order.p }}</td>
                    <td class="p-0 font-small-3" style="float: left">{{ order.q }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
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
            lastOrders: [],
        }
    },
    mounted() {

    },
    created() {
        Echo.channel(`${this.channelprefix}get-last-order-${this.market.symbol}`).listen(".App\\Events\\Binance\\GetLastOrdersEvent", e => {
            this.lastOrders.unshift(JSON.parse(e))
            if (this.lastOrders.length > 17) {
                this.lastOrders.pop()
            }
        });
    },
}
</script>
