<?php


$composerJson = json_decode(file_get_contents('composer.json'), true);
$normalized = json_encode($composerJson, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$hash = hash('sha256', $normalized);

echo "Hash: " . $hash . PHP_EOL;
