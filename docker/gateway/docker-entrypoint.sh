#!/bin/sh
set -e

if [ "$1" = "start" ]; then
    symfony server:start --allow-http --allow-all-ip --no-tls
fi

exec "$@"
