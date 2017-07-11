<?php
require __DIR__.'/vendor/autoload.php';
Arrilot\BitrixMigrations\MigratorCli::start(__DIR__, './local/migrations', 'migrations');