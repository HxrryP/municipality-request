<?php
while (true) {
    echo "Running Laravel Scheduler..." . PHP_EOL;
    shell_exec('php artisan schedule:run');
    sleep(60); // Run every 60 seconds
}
