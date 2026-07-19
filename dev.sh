#!/bin/bash

# Kill existing processes on default ports
for PORT in 8000 8001 5173; do
    PID=$(lsof -ti tcp:"$PORT" 2>/dev/null)
    if [ -n "$PID" ]; then
        echo "Killing process on port $PORT (PID: $PID)..."
        kill -9 "$PID" 2>/dev/null
    fi
done
sleep 1

# Start dev environment
npx concurrently -c "#93c5fd,#c4b5fd,#fb7185,#fdba74" \
    "bash serve.sh 8000" \
    "php artisan queue:listen --tries=1 --timeout=0" \
    "php artisan pail --timeout=0" \
    "npm run dev" \
    --names=server,queue,logs,vite \
    --kill-others
