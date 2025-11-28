#!/bin/bash
# Queue Worker Script for Laravel

# Set environment variables
export QUEUE_CONNECTION=database
export DB_CONNECTION=sqlite
export DB_DATABASE=/laravel_3sem/database/database.sqlite

# Run the queue worker
php artisan queue:work --verbose --tries=3 --timeout=90
