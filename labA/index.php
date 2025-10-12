<?php // index.php
require_once __DIR__ . '/vendor/autoload.php';

$ds = DIRECTORY_SEPARATOR;
$log = new \Monolog\Logger("my_log");
$log->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . $ds . 'log.log', \Monolog\Logger::DEBUG));
$log->error("error");
$log->warning("warning");

$duck = new \Wgarycki\LabComposer\Duck($log);
$duck->quack();
$duck->quack();
$duck->quack();

