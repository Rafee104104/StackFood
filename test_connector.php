<?php
require __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Connectors\Connector;
use Illuminate\Database\Connectors\MySqlConnector;

echo "Checking Connector class...\n";
if (method_exists(Connector::class, 'createPdoConnection')) {
    echo "Connector::createPdoConnection exists.\n";
} else {
    echo "Connector::createPdoConnection DOES NOT EXIST.\n";
}

echo "Checking MySqlConnector class...\n";
if (method_exists(MySqlConnector::class, 'createPdoConnection')) {
    echo "MySqlConnector::createPdoConnection exists.\n";
} else {
    echo "MySqlConnector::createPdoConnection DOES NOT EXIST.\n";
}

$connector = new MySqlConnector();
echo "Instance created.\n";
if (is_callable([$connector, 'createPdoConnection'])) {
    echo "Method is callable on instance.\n";
} else {
    echo "Method is NOT callable on instance.\n";
}
