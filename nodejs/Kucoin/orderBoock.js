const Redis = require('ioredis');
const redisClient = new Redis();
const {myConfig} = require('../config');
const publisher = Redis.createClient();
const Kucoin = require("kucoin-node-sdk");
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
        const chunkSize = 15;
        for (let i = 0; i < markets.length; i += chunkSize) {
            const chunk = markets.slice(i, i + chunkSize);
            const topic = `/spotMarket/level2Depth50:` + chunk.join(',')
            const callbackId = datafeed.subscribe(topic, (msg) => {
                // let random = Math.floor((Math.random() * 10) + 1);
                let depth = msg
                if (typeof depth.data != 'undefined') {
                    let symbol = depth.topic.split(":")[1]
                    // symbol = symbol.replace("-", "")

                    let asksData = depth.data.asks;
                    let asks = {}

                    asksData.forEach(element => {
                        let elKey = element[0];
                        let elValue = element[1];
                        let obj = {}
                        obj[elKey + " "] = elValue
                        Object.assign(asks, obj);
                    })
                    let dataAsks = {'symbol': symbol, 'asks': asks}
                    // if (random === 2)
                    publisher.publish(`${myConfig.redis_prefix}ask-subscribe-${symbol.replace('-', '')}`, JSON.stringify(dataAsks))


                    let bidsData = depth.data.bids;
                    let bids = {}
                    bidsData.forEach(element => {
                        let elKey = element[0];
                        let elValue = element[1];
                        let obj = {}
                        obj[elKey + " "] = elValue
                        Object.assign(bids, obj);
                    })
                    let dataBids = {'symbol': symbol, 'bids': bids}

                    // if (random === 2)
                    publisher.publish(`${myConfig.redis_prefix}bid-subscribe-${symbol.replace('-', '')}`, JSON.stringify(dataBids))
                }

            })

            console.log(`subscribe Id: ${callbackId}`);
        }
    } catch
        (err) {
        console.log(err)
    }
}


run()








