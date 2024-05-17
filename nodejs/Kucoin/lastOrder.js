const Kucoin = require('kucoin-node-sdk');
const Redis = require('ioredis');
const redisClient = new Redis();
const {myConfig} = require('../config')
const publisher = Redis.createClient();

const config = {
    baseUrl: 'https://api.kucoin.com',
    apiAuth: {
        key: '',
        secret: '',
        passphrase: ''
    },
    authVersion: 2
}
Kucoin.init(config);

// ws demo
const datafeed = new Kucoin.websocket.Datafeed();

// close callback
datafeed.onClose(() => {
    console.log('ws closed, status ', datafeed.trustConnected);
});

// connect
datafeed.connectSocket();


async function getMarketList() {
    return await redisClient.get(`${myConfig.redis_prefix}kucoin_markets`)
}

async function run() {
    try {
        const markets = Object.values(JSON.parse(await getMarketList()));

// subscribe
        const chunkSize = 15;
        for (let i = 0; i < markets.length; i += chunkSize) {
            const chunk = markets.slice(i, i + chunkSize);
            const topic = `/market/match:` + chunk.join(',');
            const callbackId = datafeed.subscribe(topic, (message) => {
                if (typeof message.data != 'undefined') {
                    const data = {
                        "symbol": message.data.symbol,
                        "T": (message.data.time + '').substring(0, 10),
                        "m": message.data.side === "sell",
                        "p": message.data.price,
                        "q": message.data.size,
                    }
                    let redisData = {
                        'event': 'App\\Events\\Binance\\GetLastOrdersEvent',
                        'data': JSON.stringify(data)
                    }
                    publisher.publish(`${myConfig.redis_prefix}get-last-order-${message.data.symbol}`, JSON.stringify(redisData));
                }
            });

            console.log(`subscribe id: ${callbackId}`);
        }
    } catch
        (error) {
    }
}


run()
