<?php

require '../../vendor/autoload.php';

$client = new Aws\Swf\SwfClient([
    'version' => 'latest',
    'region'  => 'ap-northeast-1'
]);

// Generate a random workflow ID
$workflowId = mt_rand(1000, 9999);

//var_dump($workflowId);

// Starts a new instance of our workflow
$client->startWorkflowExecution(array(
    "domain" => "testDomainFromPHP",
    "workflowId" => (string)$workflowId,
    "workflowType" => array(
        "name" => "testWorkFlow",
        "version" => "1.0"
    ),
    "taskList" => array(
        "name" => "mainTaskList"
    ),
    "input" => "hogehoge",
    "executionStartToCloseTimeout" => "300",
    'taskStartToCloseTimeout' => "300",
    "childPolicy" => "TERMINATE"
));