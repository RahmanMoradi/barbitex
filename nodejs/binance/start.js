const Redis = require('ioredis');
const redisClient = new Redis();
const {myConfig} = require('../config');

const Binance = require('node-binance-api');
const binance = new Binance().options();

const publisher = Redis.createClient();

async function getMarketList() {
    return await redisClient.get(`${myConfig.redis_prefix}binance_markets`)
}

async function run() {
    const markets = Object.values(JSON.parse(await getMarketList()));
    binance.websockets.depthCache(markets, (symbol, depth) => {
        let bids = binance.sortBids(depth.bids);
        let asks = binance.sortAsks(depth.asks);
        var data = {'symbol': symbol, 'asks': asks, 'bids': bids}

        publisher.publish(`${myConfig.redis_prefix}ask-subscribe-${symbol}`, JSON.stringify(data));
        publisher.publish(`${myConfig.redis_prefix}bid-subscribe-${symbol}`, JSON.stringify(data));
    }, 100);

    binance.websockets.prevDay(false, (error, response) => {
        if (markets.includes(response.symbol)) {
            let data = {
                'symbol': response.symbol,
                'high': response.high,
                'low': response.low,
                'close': response.close,
                'volume': response.volume,
                'percentChange': response.percentChange,
            }
            let redisData = {
                'event': 'App\\Events\\Binance\\GetTicker',
                'data': JSON.stringify(data)
            }
            publisher.publish(`${myConfig.redis_prefix}ticker-update-channels`, JSON.stringify(redisData));
        }
    });
    binance.websockets.aggTrades(markets, (response, error) => {
        const data = {
            "symbol": response.s,
            "T": response.T,
            "m": response.m,
            "p": response.p,
            "q": response.q,
        }
        let redisData = {
            'event': 'App\\Events\\Binance\\GetLastOrdersEvent',
            'data': JSON.stringify(data)
        }
        publisher.publish(`${myConfig.redis_prefix}get-last-order-${response.s}`, JSON.stringify(redisData));
    });
}

run()
