* 前提
    * AWS SDK for PHPv3がインストールされている
    * マネコンで以下を作成済
        * ドメイン：testDomainFromPHP
        * ワークフロータイプ：workflowType
        * アクティビティタイプ：testActivity
    * １度アクティビティが実行されたら完了する
* 参考
    * https://github.com/ximbal/AWS_SWF_Demo
* 使い方
    * 以下順番に実行
    * workflowexecution.php
    * deider.php（１回目。アクティビティをスケジュール）
    * workder.php
    * decider.php（２回目。ワークフロー完了）
    
