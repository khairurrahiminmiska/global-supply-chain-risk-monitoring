#!/bin/bash
PORT=${1:-8000}

PID=$(lsof -ti tcp:"$PORT" 2>/dev/null)
if [ -n "$PID" ]; then
    echo "Killing existing process on port $PORT (PID: $PID)..."
    kill -9 "$PID" 2>/dev/null
    sleep 1
fi

echo "Starting server on http://127.0.0.1:$PORT"
php artisan serve --port="$PORT"
