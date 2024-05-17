const Kucoin = require('kucoin-node-sdk');
const Redis = require('ioredis');
const redisClient = new Redis();
const {myConfig} = require('../config');
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
            const topic = `/market/snapshot:` + chunk.join(',');

            const callbackId = datafeed.subscribe(topic, (message) => {
                let response = message.data.data
                let percent = parseFloat(((response.lastTradedPrice * 100) / (response.lastTradedPrice - response.changePrice) - 100).toString()).toFixed(2)
                let data = {
                    'symbol': response.symbol,
                    'high': toFixed(response.high),
                    'low': toFixed(response.low),
                    'close': toFixed(response.lastTradedPrice),
                    'volume': response.volValue,
                    'percentChange': percent,
                }
                let redisData = {
                    'event': 'App\\Events\\Binance\\GetTicker',
                    'data': JSON.stringify(data)
                }
                publisher.publish(`${myConfig.redis_prefix}ticker-update-channels`, JSON.stringify(redisData));
            });
        }
    } catch
        (error) {
    }
}

function toFixed(x) {
    if (Math.abs(x) < 1.0) {
        var e = parseInt(x.toString().split('e-')[1]);
        if (e) {
            x *= Math.pow(10,e-1);
            x = '0.' + (new Array(e)).join('0') + x.toString().substring(2);
        }
    } else {
        var e = parseInt(x.toString().split('+')[1]);
        if (e > 20) {
            e -= 20;
            x /= Math.pow(10,e);
            x += (new Array(e+1)).join('0');
        }
    }
    return x;
}

run()
