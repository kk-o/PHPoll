#!/usr/local/bin/php
<?php
date_default_timezone_set('America/Los_Angeles');
$database = "dbquestion.db";
$table = "questiondata";
try {
  $db = new SQLite3($database);
} catch (Exception $exception) {
  echo '<p>There was an error connecting to the database!</p>';

  if ($db) {
    echo $exception->getMessage();
  }
}

$poll_id = $_GET['poll_id'];
$sql = "SELECT * FROM $table";
$result = $db->query($sql);

while ($record = $result->fetchArray()) {

  if ($record['poll_id'] == $poll_id) {
    print $record['question'] . ";";
    print $record['answer1'] . ";";
    print $record['answer2'] . ";";

    if ($record['answer3'] != "not_set") {
      print $record['answer3'] . ";";
    }
    if ($record['answer4'] != "not_set") {
      print $record['answer4'] . ";";
    }
  }
}
?> 