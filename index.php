<?php

require_once "vendor/autoload.php";

use taskforce\exceptions\ActionException;
use taskforce\exceptions\ConverterException;
use taskforce\exceptions\RoleException;
use taskforce\task\Task;
use taskforce\services\CSVConverter;

$task = new Task(11, 22);

try {
    $task->setUserId(11);
    $actionAccept = $task->getAction('STATUS_NEW');

    $task->setUserId(22);
    $actionCancel = $task->getAction('STATUS_NEW');

    $task->setUserId(11);
    $actionFailure = $task->getAction('STATUS_ACTIVE');

    $task->setUserId(22);
    $actionComplete = $task->getAction('STATUS_ACTIVE');

    $task->setUserId(22);
    $actionPublish = $task->getAction();

    $task->setUserId(33);
    $actionStdClass = $task->getAction();
} catch (RoleException $e) {
    echo '<pre> Ошибка определения роли: ' . $e->getMessage() . '<pre>';
}

try {
    $task->getStatus('ACTION_EXCEPTION');
} catch (ActionException $e) {
    echo '<pre> Ошибка получения статуса: ' . $e->getMessage() . '<pre>';
}

try {
    $csvConverter = new CSVConverter();
    $csvConverter->convertData($_SERVER['DOCUMENT_ROOT'] . '/data/categories.csv', 'sql');
    $csvConverter->convertData($_SERVER['DOCUMENT_ROOT'] . '/data/cities.csv', 'sql');
    $csvConverter->convertData($_SERVER['DOCUMENT_ROOT'] . '/data/opinions.csv', 'sql');
    $csvConverter->convertData($_SERVER['DOCUMENT_ROOT'] . '/data/profiles.csv', 'sql');
    $csvConverter->convertData($_SERVER['DOCUMENT_ROOT'] . '/data/replies.csv', 'sql');
    $csvConverter->convertData($_SERVER['DOCUMENT_ROOT'] . '/data/tasks.csv', 'sql');
    $csvConverter->convertData($_SERVER['DOCUMENT_ROOT'] . '/data/users.csv', 'sql');
} catch (ConverterException $e) {
    var_dump($e->getMessage()); die();
}

echo('<pre>');
var_dump($actionAccept);
echo('<pre>');
var_dump($actionCancel);
echo('<pre>');
var_dump($actionFailure);
echo('<pre>');
var_dump($actionComplete);
echo('<pre>');
var_dump($actionPublish);
echo('<pre>');
die();
