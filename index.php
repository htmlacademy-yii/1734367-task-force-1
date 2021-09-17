<?php

require_once "vendor/autoload.php";

use taskforce\task\Task;

$task = new Task(11, 22);

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
var_dump($actionStdClass);
die();
