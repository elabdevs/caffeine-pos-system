#!/usr/bin/env node

const net = require('net');
const fs = require('fs');
const path = require('path');

const host = process.env.EMULATOR_HOST || '127.0.0.1';
const port = parseInt(process.env.EMULATOR_PORT || '9100', 10);
const outputDir = path.join(__dirname, '_prints');

if (!fs.existsSync(outputDir)) {
    fs.mkdirSync(outputDir, { recursive: true });
}

let counter = 0;

const server = net.createServer(socket => {
    const chunks = [];
    socket.on('data', data => {
        chunks.push(data);
    });

    socket.on('end', () => {
        if (!chunks.length) {
            return;
        }
        const buffer = Buffer.concat(chunks);
        const stamp = new Date().toISOString().replace(/[:.]/g, '-');
        const fileName = `print-${stamp}-${++counter}.escpos`;
        const filePath = path.join(outputDir, fileName);
        fs.writeFile(filePath, buffer, err => {
            if (err) {
                console.error('[emulator] Failed to write print file:', err.message);
                return;
            }
            console.log(`[emulator] Saved ${fileName} (${buffer.length} bytes)`);
        });
    });

    socket.on('error', err => {
        console.error('[emulator] Socket error:', err.message);
    });
});

server.on('listening', () => {
    console.log(`[emulator] Listening on ${host}:${port}`);
});

server.on('error', err => {
    console.error('[emulator] Server error:', err.message);
    process.exit(1);
});

server.listen(port, host);
