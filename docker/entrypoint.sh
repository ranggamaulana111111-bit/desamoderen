#!/bin/sh
set -e

run_as() {
    if command -v runuser >/dev/null 2>&1; then
        runuser -u www-data -- "$@"
    elif command -v su >/dev/null 2>&1; then
        su -s /bin/sh www-data -c "$(printf '%q ' "$@")"
    else
        "$@"
    fi
}

setup_app() {
    echo ">> Preparing application ..."

    mkdir -p storage/framework/{sessions,views,cache} storage/logs
    chown -R www-data:www-data storage bootstrap/cache
    chmod -R 775 storage bootstrap/cache

    if [ -z "${APP_KEY:-}" ]; then
        echo ">> APP_KEY not set, generating temporary key ..."
        APP_KEY="base64:$(php -r 'echo base64_encode(random_bytes(32));')"
        export APP_KEY
    fi

    echo ">> Running migrations ..."
    run_as php artisan migrate --force

    echo ">> Running seeders ..."
    run_as php artisan db:seed --force

    echo ">> Optimizing ..."
    run_as php artisan optimize

    echo ">> Application ready."
}

case "${1:-}" in
    php-fpm|"")
        setup_app
        exec php-fpm
        ;;
    php)
        exec "$@"
        ;;
esac

exec "$@"
