<?php
/**
 * BOOTSTRAP ДЛЯ PHPUnit
 * Загружает автолоадер composer и поднимает само приложение,
 * как это делалось в core/bootstrap.php в методичке.
 */
$_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__);

require_once __DIR__ . '/SiteTest.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// собственный bootstrap фреймворка
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/bootstrap.php';