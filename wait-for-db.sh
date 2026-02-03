#!/bin/sh

host="$1"
shift

echo "Waiting for MySQL at $host:3306..."

until nc -z "$host" 3306; do
  sleep 2
done

echo "MySQL is up! Starting Apache..."
exec "$@"
