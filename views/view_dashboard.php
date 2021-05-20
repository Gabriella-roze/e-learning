<?php
require_once(__DIR__.'/../db/db.php');

try {
$q = $db->prepare('SELECT t.name
  FROM exam.topic t JOIN exam.user_topic_log l
  ON t.topic_id = l.topic_id
  WHERE user_id = :id AND seen = true;');
  $q->bindValue(':id', 1);
  $q->execute();
  $topics = $q->fetchAll();
  ?>
<p>Your statistics</p>
<?php
  foreach($topics as $topic) {
?>

<div class="seen-topics">
<div><?= $topic['name']?></div>
</div>

<?php
}

$q = $db->prepare('SELECT * FROM exam.topic');
  $q->execute();
  $all_topics = $q->fetchAll();
?>
<p>Explore topics</p>
<?php
  foreach($all_topics as $one_topic) {
?>
<div class="all-topics">
<div><?= $one_topic['name']?></div>
</div>

<?php
}

} catch(PDOException $ex) {
echo $ex->getMessage();
}