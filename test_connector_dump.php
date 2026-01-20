<?php
require __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Connectors\Connector;

$reflector = new ReflectionClass(Connector::class);
$file = $reflector->getFileName();
$start = $reflector->getStartLine();
$end = $reflector->getEndLine();

echo "File: $file\n";
echo "Lines: $start to $end\n";

$content = file($file);
$length = $end - $start + 1;
$lines = array_slice($content, $start - 1, $length);

echo "--- SOURCE START ---\n";
echo implode("", $lines);
echo "--- SOURCE END ---\n";
