<?php

require '../vendor/autoload.php';

ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
ini_set('xdebug.var_display_max_depth', -1);

$client = new Aws\Swf\SwfClient([
    'version' => 'latest',
    'region'  => 'ap-northeast-1'
]);


echo "pollForDecisionTask1\n";
// Ask SWF for things the decider needs to know
$result = $client->pollForDecisionTask(array(
    "domain" => "testDomainFromPHP",
    "taskList" => array(
        "name" => "mainTaskList"
    ),
    "identify" => "default",
    "maximumPageSize" => 50,
    "reverseOrder" => true
));

$activity_type_version = "1.0";
$task_token = $result["taskToken"];

if(!isAtivityCompleted($result["events"])){
    $activity_type_name = "testActivity";
    $task_list = "mainTaskList";
    $activity_id = "1";
    $continue_workflow = true;
}else{
    $continue_workflow = false;
}

// Now that we populated our variables based on what we received from SWF, we need to tell SWF what we want to do next
if($continue_workflow === true) {
    $result2 = $client->respondDecisionTaskCompleted(array(
        "taskToken" => $task_token,
        "decisions" => array(
            array(
                "decisionType" => "ScheduleActivityTask",
                "scheduleActivityTaskDecisionAttributes" => array(
                    "activityType" => array(
                        "name" => $activity_type_name,
                        "version" => $activity_type_version
                    ),
                    "activityId" => $activity_id,
                    "control" => "this is a sample message",
                    "scheduleToCloseTimeout" => "360",
                    "scheduleToStartTimeout" => "300",
                    "startToCloseTimeout" => "60",
                    "heartbeatTimeout" => "60",
                    "taskList" => array(
                        "name" => $task_list
                    ),
                    "input" => "this is a sample message"
                )
            )
        )
    ));
} else if($continue_workflow === false){
    $client->respondDecisionTaskCompleted(array(
        "taskToken" => $task_token,
        "decisions" => array(
            array(
                "decisionType" => "CompleteWorkflowExecution"
            )
        )
    ));
}


function isAtivityCompleted(array $events){
    foreach ($events as $event){
        $eventType = $event["eventType"];
        if($eventType === "ActivityTaskCompleted"){
            return true;
        }
    }
    return false;
}