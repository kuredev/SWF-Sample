<?php
require '../vendor/autoload.php';
$client = new Aws\Swf\SwfClient([
    'version' => 'latest',
    'region'  => 'ap-northeast-1'
]);

$result = $client->pollForActivityTask(array(
    "domain" => "testDomainFromPHP",
    "taskList" => array(
        "name" => "mainTaskList"
    )
));
$task_token = $result["taskToken"];

//何かアクティビティとして処理をする
// *********

// Tell SWF that we finished what we need to do on this node
$client->respondActivityTaskCompleted(array(
    "taskToken" => $task_token,
    "result" => "I've finished!"
));



