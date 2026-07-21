#!/bin/bash
PORT=${1:-8000}

# Kill existing process on target port
PID=$(lsof -ti tcp:"$PORT" 2>/dev/null)
if [ -n "$PID" ]; then
    kill -9 "$PID" 2>/dev/null
    sleep 0.5
fi

# Run server with auto-restart on crash
while true; do
    echo "Starting server on http://127.0.0.1:$PORT"
    php artisan serve --port="$PORT" 2>/tmp/php-serve-error.log
    EXIT_CODE=$?
    if [ $EXIT_CODE -ne 0 ] && [ $EXIT_CODE -ne 130 ] && [ $EXIT_CODE -ne 143 ]; then
        echo "Server crashed (exit code $EXIT_CODE), restarting in 1s..."
        tail -5 /tmp/php-serve-error.log 2>/dev/null
        sleep 1
    else
        exit 0
    fi
done
