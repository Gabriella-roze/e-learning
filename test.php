<?php
require_once(__DIR__.'/db/db.php');
$key = 'QUIZZES';
try {
    // Create a Redis Instance
    $redis = new Redis();
    // Try to connect to a redis server
    // In this case within the host machine and the default port of redis
    $redis->connect('127.0.0.1', 6379);

    if (!$redis->get($key)) {
        $q = $db->prepare('SELECT * FROM exam.topic');
        $q->execute();
        $quizzes = $q->fetch();
    
        $redis->set($key, serialize($quizzes));
        $redis->expire($key, 10);
        $source = 'Postgresql Server';
    
    } else {
         $source = 'Redis Server';
         $quizzes = unserialize($redis->get($key));
    
    }
    echo $source . ': <br>';
    print_r($quizzes);
    
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<div><?= $quizzes['name']?></div>
</body>
</html>