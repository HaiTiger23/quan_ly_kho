const httpServer = require("http").createServer();
let io = require("socket.io")(httpServer, {
    cors: {
        origin: "http://127.0.0.1:8000",
        methods: ["GET", "POST"],
    },
});
io.listen(6001);
console.log("connect to port 6001");

io.on("connection", (socket) => {
    console.log("someone was connect to your server", socket.id);
});

const Redis = require("ioredis");
const redis = new Redis(1000);
redis.psubscribe("*", (error, count) => {
    //
});

redis.on("pmessage", (pattern, channel, message) => {
    console.log("Redis pmessage:");
    console.log("Pattern:", pattern);
    console.log("Channel:", channel);
    console.log("Message:", message);

    // Parse dữ liệu từ message
    let data = JSON.parse(message);

    // Gửi lại sự kiện Redis tới tất cả client qua Socket.IO
    io.emit(channel, data);
});
