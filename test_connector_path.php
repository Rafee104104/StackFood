<?php
require __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Connectors\Connector;

echo "Checking Connector class file path...\n";
$reflector = new ReflectionClass(Connector::class);
echo "File: " . $reflector->getFileName() . "\n";
