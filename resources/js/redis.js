const redis = require('redis');
// Configuration: adapt to your environment
const REDIS_SERVER = "185.110.191.218:6379";


// Connect to Redis and subscribe to "app:notifications" channel
var redisClient = redis.createClient(REDIS_SERVER);
redisClient.subscribe('app:notifications');
