const Binance = require('binance-api-node').default
const Redis = require('ioredis');
const {myConfig} = require('../config');
const publisher = Redis.createClient();

const binanceAuth = Binance({
    apiKey: myConfig.binance.apiKey,
    apiSecret: myConfig.binance.apiSecret
});

async function run() {
    const clean = await binanceAuth.ws.user(msg => {
        if (msg.eventType === 'executionReport') {
            let order = {
                'symbol': msg.symbol,
                'side': msg.side,
                'orderType': msg.orderType,
                'qty': msg.quantity,
                'price': msg.price,
                'type': msg.executionType,
                'orderId': msg.orderId,
                'status': msg.orderStatus,
                'commission': msg.commission
            }
            if (order.status === 'FILLED'){
                let data = {'order':order}

                publisher.publish(`${myConfig.redis_prefix}market-order-update`, JSON.stringify(data));
            }
        }
    })
}

run()
