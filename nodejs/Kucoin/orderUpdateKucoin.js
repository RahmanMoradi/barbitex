const Redis = require('ioredis');
const {myConfig} = require('../config');
const publisher = Redis.createClient();
const kucoin = require('kucoin-node-api');
const config = {
    apiKey: myConfig.kucoin.apiKey,
    secretKey: myConfig.kucoin.secretKey,
    passphrase: myConfig.kucoin.passphrase,
    environment: myConfig.kucoin.environment
}


kucoin.init(config)


try {
    kucoin.initSocket({topic: "orders"}, (message) => {
        let msg = JSON.parse(message)
        console.log(message)
        if (msg.topic === '/spotMarket/tradeOrders') {
            let order = {
                'symbol': msg.data.symbol,
                'side': msg.data.side,
                'orderType': msg.data.orderType,
                'qty': msg.data.orderType === 'limit' ? msg.data.size : msg.data.filledSize,
                'price': msg.data.orderType === 'limit' ? msg.data.price : 0,
                'type': msg.data.orderType === 'limit' ? msg.data.type : (msg.data.status == 'done' ? 'filled' : 'canceled'),
                'orderId': msg.data.orderId,
                'status': msg.data.status,
                'commission': ''
            }
            if (order.orderType === 'limit') {
                if (order.type === 'filled') {
                    let data = {'order': order}

                    publisher.publish(`${myConfig.redis_prefix}market-order-update`, JSON.stringify(data));
                }
            } else if (order.orderType === 'market') {
                if (msg.data.remainFunds === "0" || msg.data.remainSize === "0") {
                    let data = {'order': order}

                    publisher.publish(`${myConfig.redis_prefix}market-order-update`, JSON.stringify(data));
                }
            }
        }

    })
} catch
    (err) {
    console.log(err)
}







